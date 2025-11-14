<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Categories extends Component
{
    public $name = '';
    public $type = 'expense';
    public $color = '#FF6B6B';
    public $icon = '📦';
    
    // For editing
    public $editingId = null;
    public $editName = '';
    public $editType = '';
    public $editColor = '';
    public $editIcon = '';

    // Predefined icons for quick selection
    public $expenseIcons = ['🍔', '🚗', '🛍️', '🎬', '💡', '🏥', '📚', '🏠', '✈️', '🎮', '☕', '👕'];
    public $incomeIcons = ['💰', '💻', '📈', '💵', '🏦', '💳', '🎁', '📊'];

    public function saveCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:expense,income',
            'color' => 'required|string',
            'icon' => 'required|string',
        ]);

        Category::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'type' => $this->type,
            'color' => $this->color,
            'icon' => $this->icon,
        ]);

        $this->reset(['name', 'icon']);
        $this->color = $this->type == 'expense' ? '#FF6B6B' : '#4ECB71';
        
        session()->flash('message', 'Category created successfully!');
    }

    public function editCategory($id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        
        $this->editingId = $id;
        $this->editName = $category->name;
        $this->editType = $category->type;
        $this->editColor = $category->color;
        $this->editIcon = $category->icon;
    }

    public function updateCategory()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editType' => 'required|in:expense,income',
            'editColor' => 'required|string',
            'editIcon' => 'required|string',
        ]);

        $category = Category::where('user_id', Auth::id())->findOrFail($this->editingId);
        
        $category->update([
            'name' => $this->editName,
            'type' => $this->editType,
            'color' => $this->editColor,
            'icon' => $this->editIcon,
        ]);

        $this->editingId = null;
        session()->flash('message', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = Category::where('user_id', Auth::id())->findOrFail($id);
        
        // Check if category has transactions
        if ($category->transactions()->count() > 0) {
            session()->flash('error', 'Cannot delete category with existing transactions!');
            return;
        }
        
        $category->delete();
        session()->flash('message', 'Category deleted successfully!');
    }

    public function cancelEdit()
    {
        $this->editingId = null;
    }

    public function render()
    {
        $expenseCategories = Category::where('user_id', Auth::id())
            ->where('type', 'expense')
            ->withCount('transactions')
            ->get();

        $incomeCategories = Category::where('user_id', Auth::id())
            ->where('type', 'income')
            ->withCount('transactions')
            ->get();

        return view('livewire.categories', [
            'expenseCategories' => $expenseCategories,
            'incomeCategories' => $incomeCategories,
        ]);
    }
}