<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Transactions extends Component
{
    use WithPagination;

    public $search = '';
    public $type_filter = 'all';
    public $category_filter = '';
    public $date_from = '';
    public $date_to = '';
    
    // For editing
    public $editingId = null;
    public $editType = '';
    public $editCategoryId = '';
    public $editAmount = '';
    public $editDescription = '';
    public $editDate = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteTransaction($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        $transaction->delete();
        
        session()->flash('message', 'Transaction deleted successfully!');
    }

    public function editTransaction($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
        
        $this->editingId = $id;
        $this->editType = $transaction->type;
        $this->editCategoryId = $transaction->category_id;
        $this->editAmount = $transaction->amount;
        $this->editDescription = $transaction->description;
        $this->editDate = $transaction->transaction_date->format('Y-m-d');
    }

    public function updateTransaction()
    {
        $this->validate([
            'editType' => 'required|in:expense,income',
            'editCategoryId' => 'required|exists:categories,id',
            'editAmount' => 'required|numeric|min:0.01',
            'editDate' => 'required|date',
        ]);

        $transaction = Transaction::where('user_id', Auth::id())->findOrFail($this->editingId);
        
        $transaction->update([
            'type' => $this->editType,
            'category_id' => $this->editCategoryId,
            'amount' => $this->editAmount,
            'description' => $this->editDescription,
            'transaction_date' => $this->editDate,
        ]);

        $this->editingId = null;
        session()->flash('message', 'Transaction updated successfully!');
    }

    public function cancelEdit()
    {
        $this->editingId = null;
    }

    public function render()
    {
        $query = Transaction::where('user_id', Auth::id())
            ->with('category');

        // Apply filters
        if ($this->type_filter !== 'all') {
            $query->where('type', $this->type_filter);
        }

        if ($this->category_filter) {
            $query->where('category_id', $this->category_filter);
        }

        if ($this->date_from) {
            $query->whereDate('transaction_date', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('transaction_date', '<=', $this->date_to);
        }

        if ($this->search) {
            $query->where('description', 'like', '%' . $this->search . '%');
        }

        $transactions = $query->orderBy('transaction_date', 'desc')->paginate(15);
        
        $categories = Category::where('user_id', Auth::id())->get();

        return view('livewire.transactions', [
            'transactions' => $transactions,
            'categories' => $categories,
        ]);
    }
}