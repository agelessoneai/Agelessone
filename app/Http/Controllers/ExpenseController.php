<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\WorkSite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    public function myExpenses(Request $request): View
    {
        $expenses = Expense::with('workSite')
            ->where('user_id', $request->user()->id)
            ->latest('expense_date')
            ->latest('id')
            ->paginate(15);

        return view('expenses.my-expenses', [
            'expenses' => $expenses,
            'workSites' => WorkSite::orderBy('site_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'expense_date' => ['required', 'date', 'before_or_equal:today'],
            'purpose' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:3000'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:9999999999.99'],
            'work_site_id' => ['nullable', 'exists:work_sites,id'],
            'bill' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
        ]);

        $data['user_id'] = $request->user()->id;
        $data['status'] = 'pending';

        if ($request->hasFile('bill')) {
            $data['bill_path'] = $request->file('bill')->store('expenses/bills', 'public');
        }

        unset($data['bill']);
        Expense::create($data);

        return back()->with('success', 'Expense submitted to Accounts for review.');
    }

    public function index(Request $request): View
    {
        $query = Expense::with(['user', 'workSite', 'reviewer'])->latest('expense_date')->latest('id');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }
        if ($request->filled('work_site_id')) {
            $query->where('work_site_id', $request->integer('work_site_id'));
        }
        if ($request->filled('from')) {
            $query->whereDate('expense_date', '>=', $request->date('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('expense_date', '<=', $request->date('to'));
        }

        $summary = [
            'pending' => (clone $query)->where('status', 'pending')->sum('amount'),
            'approved' => Expense::where('status', 'approved')->sum('amount'),
            'rejected' => Expense::where('status', 'rejected')->sum('amount'),
        ];

        return view('expenses.index', [
            'expenses' => $query->paginate(25)->withQueryString(),
            'workSites' => WorkSite::orderBy('site_name')->get(),
            'summary' => $summary,
        ]);
    }

    public function review(Request $request, Expense $expense): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'review_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $expense->update([
            'status' => $data['status'],
            'review_note' => $data['review_note'] ?? null,
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Expense review updated.');
    }

    public function destroy(Request $request, Expense $expense): RedirectResponse
    {
        abort_unless($expense->user_id === $request->user()->id && $expense->status === 'pending', 403);

        if ($expense->bill_path) {
            Storage::disk('public')->delete($expense->bill_path);
        }
        $expense->delete();

        return back()->with('success', 'Pending expense deleted.');
    }
}
