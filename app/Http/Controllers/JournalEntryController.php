<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;

class JournalEntryController extends Controller
{
    public function index()
    {
        $journals = JournalEntry::with('items.account')
            ->latest()
            ->get();

        return view('journals.index', compact('journals'));
    }

    public function show(JournalEntry $journal)
    {
        $journal->load('items.account');
        return view('journals.show', compact('journal'));
    }
}
