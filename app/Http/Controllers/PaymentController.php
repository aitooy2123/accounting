<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $query = Payment::with([
            'invoice.payments' => fn($q) => $q
                ->orderBy('payment_date')
                ->orderBy('id')
        ]);

        // 🔍 ค้นหา Invoice
        if ($request->invoice) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('invoice_no', 'like', '%' . $request->invoice . '%');
            });
        }

        // 📅 ช่วงวันที่ (แก้ย้อนหลังได้)
        if ($request->date_from) {
            $query->where(
                'payment_date',
                '>=',
                Carbon::parse($request->date_from)->startOfDay()
            );
        }

        if ($request->date_to) {
            $query->where(
                'payment_date',
                '<=',
                Carbon::parse($request->date_to)->endOfDay()
            );
        }

        // 💰 จำนวนเงิน
        if ($request->amount) {
            $query->where('amount', $request->amount);
        }

        $payments = $query
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString(); // 🔥 สำคัญ

        $invoices = Invoice::withSum('payments', 'amount')->get();

        return view('payment.index', compact('payments', 'invoices'));
    }

    public function create()
    {
        // 🔥 แสดง invoice ที่ยังไม่เต็ม
        $invoices = Invoice::withSum('payments', 'amount')
            ->get()
            ->filter(fn($i) => ($i->total - ($i->payments_sum_amount ?? 0)) > 0);

        return view('payment.create', compact('invoices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date'
        ]);

        DB::transaction(function () use ($request) {

            $invoice = Invoice::lockForUpdate()->findOrFail($request->invoice_id);

            $paid = $invoice->payments()->sum('amount');
            $balance = $invoice->total - $paid;

            // 🔥 กันจ่ายเกิน
            if ($request->amount > $balance) {
                throw new \Exception('ยอดชำระเกินคงเหลือ');
            }

            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date
            ]);

            // 🔥 update invoice
            $newPaid = $paid + $request->amount;

            $invoice->paid = $newPaid;

            if ($newPaid <= 0) {
                $invoice->status = 0;
            } elseif ($newPaid < $invoice->total) {
                $invoice->status = 1;
            } else {
                $invoice->status = 2;
            }

            $invoice->save();

            // 🔥 GL
            $entry = JournalEntry::create([
                'date' => $request->payment_date,
                'reference' => 'PAY-' . $payment->id,
                'description' => 'รับชำระเงิน Invoice: ' . $invoice->invoice_no
            ]);

            $cash = Account::where('code', '1000')->firstOrFail();
            $ar   = Account::where('code', '1100')->firstOrFail();

            JournalItem::insert([
                [
                    'journal_entry_id' => $entry->id,
                    'account_id' => $cash->id,
                    'debit' => $request->amount,
                    'credit' => 0
                ],
                [
                    'journal_entry_id' => $entry->id,
                    'account_id' => $ar->id,
                    'debit' => 0,
                    'credit' => $request->amount
                ]
            ]);
        });

        return redirect()->route('payment.index')
            ->with('success', 'บันทึกการรับเงินสำเร็จ');
    }

    // 🔥 EDIT
    public function edit(Payment $payment)
    {
        $invoices = Invoice::with('payments')->get();

        return view('payment.edit', compact('payment', 'invoices'));
    }

    // 🔥 UPDATE (สำคัญมาก)
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date'
        ]);

        $invoice = Invoice::findOrFail($request->invoice_id);

        $paidWithoutCurrent = Payment::where('invoice_id', $invoice->id)
            ->where('id', '!=', $payment->id)
            ->sum('amount');

        $balance = $invoice->total - $paidWithoutCurrent;

        // 🔥 กันเกิน
        if ($request->amount > $balance) {
            return back()
                ->withErrors(['amount' => '❌ ยอดชำระเกินคงเหลือ'])
                ->withInput();
        }

        DB::transaction(function () use ($request, $payment, $invoice) {

            $payment->update([
                'invoice_id' => $request->invoice_id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date
            ]);

            $newPaid = Payment::where('invoice_id', $invoice->id)->sum('amount');

            $invoice->paid = $newPaid;

            if ($newPaid <= 0) {
                $invoice->status = 0;
            } elseif ($newPaid < $invoice->total) {
                $invoice->status = 1;
            } else {
                $invoice->status = 2;
            }

            $invoice->save();
        });

        return redirect()->route('payment.index')->with('success', 'แก้ไขสำเร็จ');
    }

    // 🔥 DELETE
    public function destroy(Payment $payment)
    {
        DB::transaction(function () use ($payment) {

            $invoice = $payment->invoice;

            // ลบ journal
            $entry = JournalEntry::where('reference', 'PAY-' . $payment->id)->first();
            if ($entry) {
                JournalItem::where('journal_entry_id', $entry->id)->delete();
                $entry->delete();
            }

            $payment->delete();

            if ($invoice) {
                $paid = Payment::where('invoice_id', $invoice->id)->sum('amount');

                $invoice->paid = $paid;

                if ($paid <= 0) {
                    $invoice->status = 0;
                } elseif ($paid < $invoice->total) {
                    $invoice->status = 1;
                } else {
                    $invoice->status = 2;
                }

                $invoice->save();
            }
        });

        return redirect()->route('payment.index')
            ->with('success', 'ลบรายการสำเร็จ');
    }
}
