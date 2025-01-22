<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Specify the primary key
    protected $primaryKey = 'TransactionID';

    // Allow mass assignment for these fields
    protected $fillable = [
        'OrderID',
        'LoyaltyCardID',
        'UserID',
        'TotalPointsUsed',
        'PointsEarned',
        'TransactionDate',
        'UniqueIdentifier', // Add UniqueIdentifier to the fillable array
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class, 'OrderID'); // Order relationship
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID'); // User relationship (fixed column reference)
    }

    public function loyaltyCard()
    {
        return $this->belongsTo(LoyaltyCard::class, 'LoyaltyCardID'); // LoyaltyCard relationship
    }
}
