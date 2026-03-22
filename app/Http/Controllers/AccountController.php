<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::whereNull('parent_id')
            ->with('children')
            ->orderBy('code')
            ->paginate(10);

        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        $parents = Account::orderBy('code')->get();
        return view('accounts.create', compact('parents'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'code' => 'required|unique:accounts,code',
            'name' => 'required',
            'type' => 'required',
            'parent_id' => 'nullable|exists:accounts,id'
        ]);

        DB::transaction(function () use ($request) {

            Account::create([
                'code' => $request->code,
                'name' => $request->name,
                'type' => $request->type,
                'parent_id' => $request->parent_id
            ]);

        });

        return redirect()->route('accounts.index')
            ->with('success', 'เพิ่มบัญชีสำเร็จ');
    }

    public function edit(Account $account)
    {
        $parents = Account::where('id', '!=', $account->id)
            ->orderBy('code')
            ->get();

        return view('accounts.edit', compact('account', 'parents'));
    }

    public function update(Request $request, Account $account)
    {
        $request->validate([
            'code' => 'required|unique:accounts,code,' . $account->id,
            'name' => 'required',
            'type' => 'required',
            'parent_id' => 'nullable|exists:accounts,id'
        ]);

        if ($request->parent_id == $account->id) {
            return back()->withErrors(['parent_id' => 'ไม่สามารถเลือกตัวเองเป็นบัญชีแม่ได้']);
        }

        if ($account->journalItems()->count() > 0 &&
            $request->type !== $account->type) {

            return back()->withErrors([
                'type' => 'ไม่สามารถเปลี่ยนประเภทได้ เนื่องจากมีรายการบัญชีแล้ว'
            ]);
        }

        DB::transaction(function () use ($request, $account) {

            $account->update([
                'code' => $request->code,
                'name' => $request->name,
                'type' => $request->type,
                'parent_id' => $request->parent_id
            ]);

        });

        return redirect()->route('accounts.index')
            ->with('success', 'แก้ไขบัญชีสำเร็จ');
    }

    public function destroy(Account $account)
    {
        if ($account->journalItems()->exists()) {
            return back()->with('error', 'ไม่สามารถลบได้ มีรายการบัญชีใช้งานอยู่');
        }

        if ($account->children()->exists()) {
            return back()->with('error', 'ไม่สามารถลบได้ เนื่องจากมีบัญชีย่อย');
        }

        $account->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'ลบบัญชีสำเร็จ');
    }
}
