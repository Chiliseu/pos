<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

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
                $user->UniqueIdentifier = 'USR-' . strtoupper(str_random(6));
            }
        });
    }

    // Relationships (assuming you have a UserRole model)
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'UserRoleID');
    }
}
