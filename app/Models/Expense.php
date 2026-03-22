<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\Payment;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'category_id', 'amount', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
