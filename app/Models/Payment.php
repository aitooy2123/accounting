<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount',
        'payment_date',
        'expense_id'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function booted()
    {
        static::saved(function ($payment) {
            self::updateInvoice($payment);
        });

        static::deleted(function ($payment) {
            self::updateInvoice($payment);
        });
    }

    private static function updateInvoice($payment)
    {
        if (!$payment->invoice_id) return;

        $invoice = Invoice::find($payment->invoice_id);
        if (!$invoice) return;

        $paid = Payment::where('invoice_id', $invoice->id)->sum('amount');

        // ✅ ใช้ paid (ตรงกับ DB)
        $invoice->paid = $paid;

        // ✅ status
        if ($paid <= 0) {
            $invoice->status = 0;
        } elseif ($paid < $invoice->total) {
            $invoice->status = 1;
        } else {
            $invoice->status = 2;
        }

        $invoice->save();
    }
}
