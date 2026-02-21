<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin' or 'organization'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    


    // If this user is an organization, returns events they created
    public function organizationEvents()
    {
        return $this->hasMany(Event::class, 'created_by', 'id');
    }
}
