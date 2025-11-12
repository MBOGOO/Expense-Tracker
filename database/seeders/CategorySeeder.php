<?php

namespace Database\Seeders;

use App\Models\Category; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
    $categories = [
            // Expense Categories
            ['name' => 'Food & Dining', 'type' => 'expense', 'color' => '#FF6B6B', 'icon' => '🍔'],
            ['name' => 'Transportation', 'type' => 'expense', 'color' => '#4ECDC4', 'icon' => '🚗'],
            ['name' => 'Shopping', 'type' => 'expense', 'color' => '#45B7D1', 'icon' => '🛍️'],
            ['name' => 'Entertainment', 'type' => 'expense', 'color' => '#FFA07A', 'icon' => '🎬'],
            ['name' => 'Bills & Utilities', 'type' => 'expense', 'color' => '#DDA15E', 'icon' => '💡'],
            ['name' => 'Healthcare', 'type' => 'expense', 'color' => '#BC6C25', 'icon' => '🏥'],
            ['name' => 'Education', 'type' => 'expense', 'color' => '#606C38', 'icon' => '📚'],
            ['name' => 'Other Expenses', 'type' => 'expense', 'color' => '#9B59B6', 'icon' => '📦'],
            
            // Income Categories
            ['name' => 'Salary', 'type' => 'income', 'color' => '#4ECB71', 'icon' => '💰'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#52B788', 'icon' => '💻'],
            ['name' => 'Investment', 'type' => 'income', 'color' => '#74C69D', 'icon' => '📈'],
            ['name' => 'Other Income', 'type' => 'income', 'color' => '#95D5B2', 'icon' => '💵'],
        ];

        // Note: We'll assign user_id when user registers
        // For now, let's just create the template categories
        foreach ($categories as $category) {
            Category::create($category + ['user_id' => 1]); // Temporary user_id
        }
}
}
