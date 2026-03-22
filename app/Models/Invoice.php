<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'customer_id',
        'total',
        'paid',
        'due_date',
        'status',
        'items'
    ];

    protected $casts = [
        'due_date' => 'date:Y-m-d',
        'items' => 'array'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getBalanceAttribute()
    {
        return $this->total - $this->paid;
    }

    // ลบ Payment ที่เกี่ยวข้องเมื่อ Invoice ถูกลบ
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($invoice) {
            // ลบ Payment ทั้งหมดที่เชื่อมกับ Invoice
            $invoice->payments()->delete();
        });
    }}
