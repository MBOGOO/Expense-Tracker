<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Reports extends Component
{
    public $period = 'month'; // month, year, custom
    public $date_from = '';
    public $date_to = '';

    public function mount()
    {
        // Default to current month
        $this->date_from = now()->startOfMonth()->format('Y-m-d');
        $this->date_to = now()->endOfMonth()->format('Y-m-d');
    }

    public function updatedPeriod()
    {
        if ($this->period == 'month') {
            $this->date_from = now()->startOfMonth()->format('Y-m-d');
            $this->date_to = now()->endOfMonth()->format('Y-m-d');
        } elseif ($this->period == 'year') {
            $this->date_from = now()->startOfYear()->format('Y-m-d');
            $this->date_to = now()->endOfYear()->format('Y-m-d');
        }
    }

    public function render()
    {
        $query = Transaction::where('user_id', Auth::id())
            ->whereBetween('transaction_date', [$this->date_from, $this->date_to]);

        // Total Income and Expenses
        $totalIncome = (clone $query)->where('type', 'income')->sum('amount');
        $totalExpenses = (clone $query)->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpenses;

        // Expenses by Category
        $expensesByCategory = (clone $query)
            ->where('type', 'expense')
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->category->name,
                    'icon' => $item->category->icon,
                    'color' => $item->category->color,
                    'total' => $item->total,
                ];
            });

        // Income by Category
        $incomeByCategory = (clone $query)
            ->where('type', 'income')
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->category->name,
                    'icon' => $item->category->icon,
                    'color' => $item->category->color,
                    'total' => $item->total,
                ];
            });

        // Daily Transactions for Chart
        $dailyData = (clone $query)
            ->select(
                DB::raw('DATE(transaction_date) as date'),
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Recent Large Transactions
        $largeTransactions = Transaction::where('user_id', Auth::id())
            ->whereBetween('transaction_date', [$this->date_from, $this->date_to])
            ->with('category')
            ->orderBy('amount', 'desc')
            ->limit(5)
            ->get();

        return view('livewire.reports', [
            'totalIncome' => $totalIncome,
            'totalExpenses' => $totalExpenses,
            'balance' => $balance,
            'expensesByCategory' => $expensesByCategory,
            'incomeByCategory' => $incomeByCategory,
            'dailyData' => $dailyData,
            'largeTransactions' => $largeTransactions,
        ]);
    }
}