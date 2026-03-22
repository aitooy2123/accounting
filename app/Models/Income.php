<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $table = 'incomes';
    protected $fillable = ['date', 'category_id', 'amount', 'description'];

    protected $appends = ['vat','grand_total'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getVatAttribute()
    {
        return $this->amount * 0.07;
    }

    public function getGrandTotalAttribute()
    {
        return $this->amount + ($this->amount * 0.07);
    }

}
