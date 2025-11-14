<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Categories</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your expense and income categories</p>
        </div>

        {{-- Success/Error Messages --}}
        @if (session()->has('message'))
            <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-green-800 dark:text-green-200 font-medium">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-800 dark:text-red-200 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Add New Category Form --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden sticky top-6">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            New Category
                        </h2>
                    </div>
                    
                    <form wire:submit.prevent="saveCategory" class="p-6 space-y-5">
                        
                        {{-- Type Toggle --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Category Type</label>
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" 
                                    wire:click="$set('type', 'expense')"
                                    class="px-4 py-3 rounded-lg font-medium transition-all duration-200 {{ $type == 'expense' ? 'bg-red-500 text-white shadow-lg' : 'bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200' }}">
                                    Expense
                                </button>
                                <button type="button"
                                    wire:click="$set('type', 'income')"
                                    class="px-4 py-3 rounded-lg font-medium transition-all duration-200 {{ $type == 'income' ? 'bg-green-500 text-white shadow-lg' : 'bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200' }}">
                                    Income
                                </button>
                            </div>
                        </div>

                        {{-- Category Name --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                            <input type="text" wire:model="name" 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g., Groceries">
                            @error('name') 
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Icon Selection --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Select Icon</label>
                            <div class="grid grid-cols-6 gap-2">
                                @foreach(($type == 'expense' ? $expenseIcons : $incomeIcons) as $emoji)
                                    <button type="button"
                                        wire:click="$set('icon', '{{ $emoji }}')"
                                        class="text-2xl p-3 rounded-lg border-2 transition-all {{ $icon == $emoji ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-zinc-700 hover:border-blue-300' }}">
                                        {{ $emoji }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Color Picker --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Color</label>
                            <div class="flex items-center space-x-3">
                                <input type="color" wire:model="color" 
                                    class="h-12 w-20 rounded-lg border border-gray-300 dark:border-zinc-700 cursor-pointer">
                                <div class="flex-1">
                                    <input type="text" wire:model="color" 
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg"
                                        placeholder="#FF6B6B">
                                </div>
                            </div>
                        </div>

                        {{-- Preview --}}
                        <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4">
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Preview</p>
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl" 
                                    style="background-color: {{ $color }}20;">
                                    {{ $icon }}
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $name ?: 'Category Name' }}</span>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3.5 px-6 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            Add Category
                        </button>
                    </form>
                </div>
            </div>

            {{-- Categories List --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Expense Categories --}}
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 px-6 py-4 border-b border-red-200 dark:border-red-800">
                        <h2 class="text-xl font-bold text-red-900 dark:text-red-200 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                            Expense Categories ({{ $expenseCategories->count() }})
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        @if($expenseCategories->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($expenseCategories as $category)
                                    @if($editingId === $category->id)
                                        {{-- Edit Mode Card --}}
                                        <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-500 rounded-lg p-4">
                                            <div class="space-y-3">
                                                <input type="text" wire:model="editName" 
                                                    class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded">
                                                
                                                <div class="grid grid-cols-6 gap-1">
                                                    @foreach($expenseIcons as $emoji)
                                                        <button type="button" wire:click="$set('editIcon', '{{ $emoji }}')"
                                                            class="text-xl p-2 rounded border {{ $editIcon == $emoji ? 'border-blue-500 bg-blue-100 dark:bg-blue-900' : 'border-gray-200 dark:border-zinc-700' }}">
                                                            {{ $emoji }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                                
                                                <input type="color" wire:model="editColor" 
                                                    class="w-full h-10 rounded cursor-pointer">
                                                
                                                <div class="flex space-x-2">
                                                    <button wire:click="updateCategory" 
                                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded font-medium">
                                                        Save
                                                    </button>
                                                    <button wire:click="cancelEdit" 
                                                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded font-medium">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Normal View Card --}}
                                        <div class="bg-gray-50 dark:bg-zinc-800 hover:bg-gray-100 dark:hover:bg-zinc-700 rounded-lg p-4 transition-all duration-200 border border-gray-200 dark:border-zinc-700">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl" 
                                                        style="background-color: {{ $category->color }}20;">
                                                        {{ $category->icon }}
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $category->name }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $category->transactions_count }} transactions</p>
                                                    </div>
                                                </div>
                                                <div class="flex space-x-2">
                                                    <button wire:click="editCategory({{ $category->id }})" 
                                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 p-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </button>
                                                    <button wire:click="deleteCategory({{ $category->id }})" 
                                                        onclick="return confirm('Are you sure?')"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-800 p-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400 py-8">No expense categories yet.</p>
                        @endif
                    </div>
                </div>

                {{-- Income Categories --}}
                <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 px-6 py-4 border-b border-green-200 dark:border-green-800">
                        <h2 class="text-xl font-bold text-green-900 dark:text-green-200 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            Income Categories ({{ $incomeCategories->count() }})
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        @if($incomeCategories->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($incomeCategories as $category)
                                    @if($editingId === $category->id)
                                        {{-- Edit Mode Card --}}
                                        <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-500 rounded-lg p-4">
                                            <div class="space-y-3">
                                                <input type="text" wire:model="editName" 
                                                    class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded">
                                                
                                                <div class="grid grid-cols-6 gap-1">
                                                    @foreach($incomeIcons as $emoji)
                                                        <button type="button" wire:click="$set('editIcon', '{{ $emoji }}')"
                                                            class="text-xl p-2 rounded border {{ $editIcon == $emoji ? 'border-blue-500 bg-blue-100 dark:bg-blue-900' : 'border-gray-200 dark:border-zinc-700' }}">
                                                            {{ $emoji }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                                
                                                <input type="color" wire:model="editColor" 
                                                    class="w-full h-10 rounded cursor-pointer">
                                                
                                                <div class="flex space-x-2">
                                                    <button wire:click="updateCategory" 
                                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded font-medium">
                                                        Save
                                                    </button>
                                                    <button wire:click="cancelEdit" 
                                                        class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 rounded font-medium">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        {{-- Normal View Card --}}
                                        <div class="bg-gray-50 dark:bg-zinc-800 hover:bg-gray-100 dark:hover:bg-zinc-700 rounded-lg p-4 transition-all duration-200 border border-gray-200 dark:border-zinc-700">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl" 
                                                        style="background-color: {{ $category->color }}20;">
                                                        {{ $category->icon }}
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $category->name }}</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $category->transactions_count }} transactions</p>
                                                    </div>
                                                </div>
                                                <div class="flex space-x-2">
                                                    <button wire:click="editCategory({{ $category->id }})" 
                                                        class="text-blue-600 dark:text-blue-400 hover:text-blue-800 p-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </button>
                                                    <button wire:click="deleteCategory({{ $category->id }})" 
                                                        onclick="return confirm('Are you sure?')"
                                                        class="text-red-600 dark:text-red-400 hover:text-red-800 p-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400 py-8">No income categories yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>