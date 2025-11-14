<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Expense Tracker - Manage Your Finances</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    html, body {
        background: linear-gradient(to bottom right, #1e3a8a, #581c87, #6d6ab2ff);
        min-height: 100vh;
    }
</style>
</head>
<body class="antialiased overflow-x-hidden">
    <div class="min-h-screen bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900">
        
        {{-- Navigation --}}
        <nav class="container mx-auto px-6 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-2xl font-bold text-white">Expense Tracker</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-blue-300 font-medium transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-300 font-medium transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition shadow-lg">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <div class="container mx-auto px-6 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                
                {{-- Left Content --}}
                <div class="text-white space-y-8">
                    <h1 class="text-5xl lg:text-6xl font-bold leading-tight">
                        Take Control of Your 
                        <span class="text-blue-400">Finances</span>
                    </h1>
                    
                    <p class="text-xl text-gray-300">
                        Track expenses, manage budgets, and visualize your spending with our simple yet powerful expense tracking application.
                    </p>

                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-lg transition shadow-xl text-center">
                            Start Free Today
                        </a>
                        <a href="#features" class="bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-bold py-4 px-8 rounded-lg transition border border-white/20 text-center">
                            Learn More
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-6 pt-8">
                        <div>
                            <p class="text-3xl font-bold text-blue-400">100%</p>
                            <p class="text-gray-400 text-sm">Free</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-blue-400">Secure</p>
                            <p class="text-gray-400 text-sm">Your Data</p>
                        </div>
                        <div>
                            <p class="text-3xl font-bold text-blue-400">Easy</p>
                            <p class="text-gray-400 text-sm">To Use</p>
                        </div>
                    </div>
                </div>

                {{-- Right Content - Feature Preview --}}
                <div class="relative">
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl">
                        <div class="space-y-6">
                            {{-- Mock Dashboard Preview --}}
                            <div class="flex items-center justify-between pb-4 border-b border-white/20">
                                <h3 class="text-white font-bold text-lg">Quick Preview</h3>
                                <span class="text-blue-400 text-sm">Dashboard</span>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-green-500/20 backdrop-blur-sm rounded-lg p-4 border border-green-500/30">
                                    <p class="text-green-300 text-sm mb-1">Income</p>
                                    <p class="text-white text-2xl font-bold">KES 50,000</p>
                                </div>
                                <div class="bg-red-500/20 backdrop-blur-sm rounded-lg p-4 border border-red-500/30">
                                    <p class="text-red-300 text-sm mb-1">Expenses</p>
                                    <p class="text-white text-2xl font-bold">KES 35,000</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-2xl">🍔</span>
                                        <span class="text-white">Food & Dining</span>
                                    </div>
                                    <span class="text-red-400 font-bold">-5,000</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-2xl">💰</span>
                                        <span class="text-white">Salary</span>
                                    </div>
                                    <span class="text-green-400 font-bold">+50,000</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-2xl">🚗</span>
                                        <span class="text-white">Transportation</span>
                                    </div>
                                    <span class="text-red-400 font-bold">-3,500</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Features Section --}}
        <div id="features" class="container mx-auto px-6 py-20">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white mb-4">Powerful Features</h2>
                <p class="text-gray-300 text-lg">Everything you need to manage your money</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 border border-white/20 hover:bg-white/20 transition">
                    <div class="w-14 h-14 bg-blue-500/20 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Visual Reports</h3>
                    <p class="text-gray-300">Beautiful charts and graphs to understand your spending patterns at a glance.</p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 border border-white/20 hover:bg-white/20 transition">
                    <div class="w-14 h-14 bg-green-500/20 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Custom Categories</h3>
                    <p class="text-gray-300">Organize transactions with personalized categories, icons, and colors.</p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white/10 backdrop-blur-lg rounded-xl p-8 border border-white/20 hover:bg-white/20 transition">
                    <div class="w-14 h-14 bg-purple-500/20 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Secure & Private</h3>
                    <p class="text-gray-300">Your financial data is encrypted and stored securely. Only you have access.</p>
                </div>
            </div>
        </div>

        {{-- CTA Section --}}
        <div class="container mx-auto px-6 py-20">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-12 text-center">
                <h2 class="text-4xl font-bold text-white mb-4">Ready to Get Started?</h2>
                <p class="text-xl text-blue-100 mb-8">Join now and take control of your finances today.</p>
                <a href="{{ route('register') }}" class="inline-block bg-white hover:bg-gray-100 text-blue-600 font-bold py-4 px-10 rounded-lg transition shadow-xl text-lg">
                    Create Free Account
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <footer class="container mx-auto px-6 py-8 border-t border-white/10">
            <div class="text-center text-gray-400">
                <p>&copy; 2025 Expense Tracker. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>