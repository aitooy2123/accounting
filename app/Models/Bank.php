<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RefBank;

class Bank extends Model
{
    protected $table = 'banks';

    protected $fillable = [
        'ref_bank_id',
        'account_name',
        'account_number'
    ];

    public function refBank()
    {
        return $this->belongsTo(RefBank::class,'ref_bank_id');
    }
}
