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
        $invoices = Invoice::where('status','unpaid')->get();
        return view('payment.create', compact('invoices'));
    }

   public function store(Request $request)
{
    $request->validate([
        'invoice_id' => 'required',
        'amount' => 'required|numeric|min:0',
        'payment_date' => 'required|date'
    ]);

    DB::transaction(function() use ($request){

        $payment = Payment::create([
            'invoice_id' => $request->invoice_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date
        ]);

        $invoice = Invoice::find($request->invoice_id);

        if($request->amount >= $invoice->total){
            $invoice->update(['status'=>'paid']);
        }

        $entry = JournalEntry::create([
            'date' => $request->payment_date,
            'reference' => 'PAY-'.$payment->id,
            'description' => 'รับชำระเงิน'
        ]);

        // เดบิต เงินสด
        JournalItem::create([
            'journal_entry_id' => $entry->id,
            'account_id' => Account::where('code','1000')->first()->id,
            'debit' => $request->amount,
            'credit' => 0
        ]);

        // เครดิต ลูกหนี้
        JournalItem::create([
            'journal_entry_id' => $entry->id,
            'account_id' => Account::where('code','1100')->first()->id,
            'debit' => 0,
            'credit' => $request->amount
        ]);

    });

    return redirect()->route('payment.index')
        ->with('success','บันทึกการรับเงินสำเร็จ');
}

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('payment.index')
            ->with('success','ลบรายการสำเร็จ');
    }
}
