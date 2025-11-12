<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'type',
        'amount',
        'description',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
    ];

    // Relationship: A transaction belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: A transaction belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}