<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;  // Make sure this is included
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable // Extends Authenticatable to implement necessary authentication methods
{
    use HasFactory, HasApiTokens;

    protected $primaryKey = 'id'; // Default primary key

    protected $fillable = [
        'name',
        'email',
        'password',
        'UserRoleID',
        'Firstname',
        'Lastname',
        'MiddleInitial',
        'Suffix',
        'ContactNo',
        'UniqueIdentifier',
        'IsDeleted',
    ];

    // Automatically generate the UniqueIdentifier when creating the user
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // Generate UniqueIdentifier in the format 'USR-random'
            if (!$user->UniqueIdentifier) {
                $user->UniqueIdentifier = 'USR-' . strtoupper(Str::random(5)); // Use Str::random() instead of str_random()
            }
        });
    }

    // Relationships (assuming you have a UserRole model)
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'UserRoleID');
    }
}
