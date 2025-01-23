<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    // The table associated with the model (optional if table follows Laravel's naming convention)
    protected $table = 'product';

    // The primary key associated with the table (optional if it's "id" by default)
    protected $primaryKey = 'ProductID';

    // The attributes that are mass assignable
    protected $fillable = ['CategoryID', 'Name', 'Price', 'UniqueIdentifier'];

    // The attributes that should be hidden for arrays (optional)
    protected $hidden = [];

    // Timestamps are enabled by default (created_at, updated_at) so no need to set it unless disabled
    public $timestamps = true;

    // Automatically generate the UniqueIdentifier when creating the product
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Generate UniqueIdentifier in the format 'PRD-random'
            if (!$product->UniqueIdentifier) {
                $product->UniqueIdentifier = 'PRD-' . Str::upper(Str::random(5));
            }
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryID');
    }

    /**
     * Get the orders that belong to the product.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'ProductID', 'OrderID')
                    ->withPivot('Quantity', 'TotalPrice');
    }
}
