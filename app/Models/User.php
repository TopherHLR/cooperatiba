<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, CanResetPassword;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'student_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    // optionally, if you want to define isStudent or isAdmin:
    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // 🔗 Relationship: User has one Student profile
    public function student()
    {
        return $this->hasOne(StudentModel::class, 'user_id');
    }
        // In User model:

    public function chats()
    {
        return $this->hasMany(ChatModel::class, 'admin_id', 'id');
    }

    public function orderHistoryUpdates()
    {
        return $this->hasMany(OrderHistoryModel::class, 'updated_by', 'id');
    }
}
