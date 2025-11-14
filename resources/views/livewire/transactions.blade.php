<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">All Transactions</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">View and manage all your transactions</p>
        </div>

        {{-- Success Message --}}
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

        {{-- Filters --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Filters</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                {{-- Search --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                    <input type="text" wire:model.live="search" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Search description...">
                </div>

                {{-- Type Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                    <select wire:model.live="type_filter" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Types</option>
                        <option value="expense">Expenses</option>
                        <option value="income">Income</option>
                    </select>
                </div>

                {{-- Category Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                    <select wire:model.live="category_filter" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Date From --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Date</label>
                    <input type="date" wire:model.live="date_from" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Date To --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To Date</label>
                    <input type="date" wire:model.live="date_to" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        {{-- Transactions Table --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                        @forelse($transactions as $transaction)
                            @if($editingId === $transaction->id)
                                {{-- Edit Mode Row --}}
                                <tr class="bg-blue-50 dark:bg-blue-900/20">
                                    <td class="px-6 py-4">
                                        <input type="date" wire:model="editDate" 
                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded">
                                    </td>
                                    <td class="px-6 py-4">
                                        <select wire:model="editCategoryId" 
                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded">
                                            @foreach($categories->where('type', $editType) as $category)
                                                <option value="{{ $category->id }}">{{ $category->icon }} {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" wire:model="editDescription" 
                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded"
                                            placeholder="Description">
                                    </td>
                                    <td class="px-6 py-4">
                                        <select wire:model="editType" 
                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded">
                                            <option value="expense">Expense</option>
                                            <option value="income">Income</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="number" step="0.01" wire:model="editAmount" 
                                            class="w-full px-2 py-1 text-sm border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded text-right">
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button wire:click="updateTransaction" 
                                            class="text-green-600 hover:text-green-800 dark:text-green-400 font-medium">
                                            Save
                                        </button>
                                        <button wire:click="cancelEdit" 
                                            class="text-gray-600 hover:text-gray-800 dark:text-gray-400 font-medium">
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            @else
                                {{-- Normal View Row --}}
                                <tr class="hover:bg-gray-50 dark:hover:bg-zinc-800/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $transaction->transaction_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-xl mr-2">{{ $transaction->category->icon }}</span>
                                            <span class="text-sm text-gray-900 dark:text-white">{{ $transaction->category->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $transaction->description ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $transaction->type == 'expense' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold {{ $transaction->type == 'expense' ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        {{ $transaction->type == 'expense' ? '-' : '+' }} KES {{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                                        <button wire:click="editTransaction({{ $transaction->id }})" 
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 font-medium">
                                            Edit
                                        </button>
                                        <button wire:click="deleteTransaction({{ $transaction->id }})" 
                                            onclick="return confirm('Are you sure you want to delete this transaction?')"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 font-medium">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No transactions found</h3>
                                        <p class="text-gray-600 dark:text-gray-400">Try adjusting your filters or add a new transaction from the dashboard.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-200 dark:border-zinc-700">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>