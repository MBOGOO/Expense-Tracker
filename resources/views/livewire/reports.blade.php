<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Reports & Analytics</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Visualize your financial data</p>
        </div>

        {{-- Period Selector --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Period</label>
                    <select wire:model.live="period" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="month">This Month</option>
                        <option value="year">This Year</option>
                        <option value="custom">Custom Range</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Date</label>
                    <input type="date" wire:model.live="date_from" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                        {{ $period != 'custom' ? 'readonly' : '' }}>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">To Date</label>
                    <input type="date" wire:model.live="date_to" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500"
                        {{ $period != 'custom' ? 'readonly' : '' }}>
                </div>

                <div class="flex items-end">
                    <button wire:click="$refresh" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                        Update Report
                    </button>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Income</p>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">
                            KES {{ number_format($totalIncome, 2) }}
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-6 border-l-4 border-red-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Expenses</p>
                        <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">
                            KES {{ number_format($totalExpenses, 2) }}
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Net Balance</p>
                        <p class="text-3xl font-bold {{ $balance >= 0 ? 'text-blue-600 dark:text-blue-400' : 'text-red-600 dark:text-red-400' }} mt-2">
                            KES {{ number_format($balance, 2) }}
                        </p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            
            {{-- Expenses by Category --}}
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 px-6 py-4 border-b border-red-200 dark:border-red-800">
                    <h2 class="text-lg font-bold text-red-900 dark:text-red-200">Expenses by Category</h2>
                </div>
                
                <div class="p-6">
                    @if($expensesByCategory->count() > 0)
                        <div class="space-y-4">
                            @foreach($expensesByCategory as $expense)
                                @php
                                    $percentage = $totalExpenses > 0 ? ($expense['total'] / $totalExpenses) * 100 : 0;
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xl">{{ $expense['icon'] }}</span>
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $expense['category'] }}</span>
                                        </div>
                                        <span class="font-bold text-red-600 dark:text-red-400">
                                            KES {{ number_format($expense['total'], 2) }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-full h-3">
                                        <div class="h-3 rounded-full transition-all duration-500" 
                                            style="width: {{ $percentage }}%; background-color: {{ $expense['color'] }};">
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ number_format($percentage, 1) }}% of total expenses</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">No expense data for this period</p>
                    @endif
                </div>
            </div>

            {{-- Income by Category --}}
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 px-6 py-4 border-b border-green-200 dark:border-green-800">
                    <h2 class="text-lg font-bold text-green-900 dark:text-green-200">Income by Category</h2>
                </div>
                
                <div class="p-6">
                    @if($incomeByCategory->count() > 0)
                        <div class="space-y-4">
                            @foreach($incomeByCategory as $income)
                                @php
                                    $percentage = $totalIncome > 0 ? ($income['total'] / $totalIncome) * 100 : 0;
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xl">{{ $income['icon'] }}</span>
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $income['category'] }}</span>
                                        </div>
                                        <span class="font-bold text-green-600 dark:text-green-400">
                                            KES {{ number_format($income['total'], 2) }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-zinc-700 rounded-full h-3">
                                        <div class="h-3 rounded-full transition-all duration-500" 
                                            style="width: {{ $percentage }}%; background-color: {{ $income['color'] }};">
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ number_format($percentage, 1) }}% of total income</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 dark:text-gray-400 py-8">No income data for this period</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Daily Trend Chart --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-zinc-800 dark:to-zinc-700 px-6 py-4 border-b border-gray-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Daily Income vs Expenses</h2>
            </div>
            
            <div class="p-6">
                @if($dailyData->count() > 0)
                    <div class="overflow-x-auto">
                        <div class="min-w-full" style="height: 300px;">
                            <canvas id="dailyChart"></canvas>
                        </div>
                    </div>
                @else
                    <p class="text-center text-gray-500 dark:text-gray-400 py-8">No transaction data for this period</p>
                @endif
            </div>
        </div>

        {{-- Top Transactions --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-zinc-800 dark:to-zinc-700 px-6 py-4 border-b border-gray-200 dark:border-zinc-700">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Top 5 Largest Transactions</h2>
            </div>
            
            <div class="p-6">
                @if($largeTransactions->count() > 0)
                    <div class="space-y-3">
                        @foreach($largeTransactions as $transaction)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-zinc-800 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-2xl" 
                                        style="background-color: {{ $transaction->category->color }}20;">
                                        {{ $transaction->category->icon }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">{{ $transaction->category->name }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $transaction->transaction_date->format('M d, Y') }}
                                        </p>
                                        @if($transaction->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $transaction->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold {{ $transaction->type == 'expense' ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                        {{ $transaction->type == 'expense' ? '-' : '+' }} 
                                        KES {{ number_format($transaction->amount, 2) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 dark:text-gray-400 py-8">No transactions for this period</p>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dailyChart');
        if (ctx && @json($dailyData->count() > 0)) {
            const dailyData = @json($dailyData);
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dailyData.map(d => {
                        const date = new Date(d.date);
                        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                    }),
                    datasets: [
                        {
                            label: 'Income',
                            data: dailyData.map(d => d.income),
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Expenses',
                            data: dailyData.map(d => d.expense),
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': KES ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'KES ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }
    });

    // Reload chart when Livewire updates
    document.addEventListener('livewire:navigated', function() {
        location.reload();
    });
</script>
@endpush