<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Transaction;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    // Form properties
    public $type = 'expense';
    public $category_id = '';
    public $amount = '';
    public $description = '';
    public $transaction_date;

    // Initialize component
    public function mount()
    {
        $this->transaction_date = now()->format('Y-m-d');
    }

    // Save new transaction
    public function saveTransaction()
    {
        $this->validate([
            'type' => 'required|in:expense,income',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
        ]);

        Transaction::create([
            'user_id' => Auth::id(),
            'category_id' => $this->category_id,
            'type' => $this->type,
            'amount' => $this->amount,
            'description' => $this->description,
            'transaction_date' => $this->transaction_date,
        ]);

        // Reset form
        $this->reset(['amount', 'description', 'category_id']);
        $this->transaction_date = now()->format('Y-m-d');
        
        session()->flash('message', 'Transaction added successfully!');
    }

    public function render()
    {
        $categories = Category::where('user_id', Auth::id())
            ->where('type', $this->type)
            ->get();

        $transactions = Transaction::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('transaction_date', 'desc')
            ->limit(10)
            ->get();

        return view('livewire.dashboard', [
            'categories' => $categories,
            'transactions' => $transactions,
        ]);
    }
}