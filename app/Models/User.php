<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Add this if you have an is_admin column
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // Add this to cast is_admin to boolean
        ];
    }

    /**
     * Check if the user is an admin
     */
    public function isAdmin(): bool
    {
        // Check if user has is_admin column set to true
        return $this->is_admin ?? false;

        // Alternative: Check by email (uncomment if you don't have is_admin column)
        // return $this->email === 'admin@example.com';

        // Alternative: Check by role column (if you have a role column)
        // return $this->role === 'admin';
    }
}
