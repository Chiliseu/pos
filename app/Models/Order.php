<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // To generate Unique Identifier

class Order extends Model
{
    use HasFactory;

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'OrderID';

    // If the primary key is not auto-incrementing (optional)
    public $incrementing = true;

    // Set the data type for the primary key (optional)
    protected $keyType = 'int';

    // Set the table name if it's not the plural form of the model (optional)
    // protected $table = 'orders';

    // If you want to fill in fields (mass-assignment)
    protected $fillable = [
        'OrderDate',
        'Subtotal',
        'Total',
        'UniqueIdentifier', // Added UniqueIdentifier here
    ];

    // Boot method to handle the generation of the UniqueIdentifier
    protected static function boot()
    {
        parent::boot();

        // Automatically generate UniqueIdentifier before creating an order
        static::creating(function ($order) {
            if (!$order->UniqueIdentifier) {
                $order->UniqueIdentifier = 'ORD-' . Str::random(5); // Format: ORD-Random
            }
        });
    }

    // Define relationships (if any)
    // For example, if you have a Customer model
}
