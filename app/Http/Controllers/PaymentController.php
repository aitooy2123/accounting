<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\JournalEntry;
use App\Models\JournalItem;
use App\Models\Account;
use Illuminate\Http\Request;
use DB;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('invoice')
            ->latest()
            ->paginate(10);

        return view('payment.index', compact('payments'));
    }

    public function create()
    {
        $invoices = Invoice::where('status', 'unpaid')->get();
        return view('payment.create', compact('invoices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date'
        ]);

        DB::transaction(function () use ($request) {

            $invoice = Invoice::findOrFail($request->invoice_id);

            // สร้าง Payment
            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date
            ]);

            // ✅ คำนวณยอดที่จ่ายทั้งหมด (รองรับ partial payment)
            $totalPaid = Payment::where('invoice_id', $invoice->id)->sum('amount');

            // ✅ update status (0 = pending, 1 = paid)
            if ($totalPaid >= $invoice->total) {
                $invoice->update(['status' => 1]);
            }

            // สร้าง Journal Entry
            $entry = JournalEntry::create([
                'date' => $request->payment_date,
                'reference' => 'PAY-' . $payment->id,
                'description' => 'รับชำระเงิน'
            ]);

            // หา account ครั้งเดียว (ลด query ซ้ำ)
            $cashAccount = Account::where('code', '1000')->firstOrFail();
            $arAccount   = Account::where('code', '1100')->firstOrFail();

            // เดบิต เงินสด
            JournalItem::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $cashAccount->id,
                'debit' => $request->amount,
                'credit' => 0
            ]);

            // เครดิต ลูกหนี้
            JournalItem::create([
                'journal_entry_id' => $entry->id,
                'account_id' => $arAccount->id,
                'debit' => 0,
                'credit' => $request->amount
            ]);
        });

        return redirect()->route('payment.index')
            ->with('success', 'บันทึกการรับเงินสำเร็จ');
    }

    public function destroy(Payment $payment)
    {
        $invoice = $payment->invoice;

        $payment->delete();

        if ($invoice) {
            $invoice->update(['status' => 0]);
        }

        return redirect()->route('payment.index')
            ->with('success', 'ลบรายการสำเร็จ');
    }
}
