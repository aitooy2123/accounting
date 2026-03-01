<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'type', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    public function journalItems()
    {
        return $this->hasMany(JournalItem::class);
    }

    public function getBalanceAttribute()
    {
        $debit = $this->journalItems()->sum('debit');
        $credit = $this->journalItems()->sum('credit');

        if (in_array($this->type, ['asset', 'expense'])) {
            return $debit - $credit;
        }

        return $credit - $debit;
    }
}
