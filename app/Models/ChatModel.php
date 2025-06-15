<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatModel extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'chat_id';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'admin_id',  // this refers to users with role = 'admin'
        'message',
        'timestamp',
        'sent_by',
        'is_read', // add this
    ];

    protected $casts = [
        'is_read' => 'boolean', // add this
        'timestamp' => 'datetime',
    ];

    // Relationships

    // Refers to the student who sent or received the message
    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id');
    }

    // Refers to the user acting as admin (User with role = 'admin')
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function scopeWithAdminRole($query)
    {
        return $query->whereHas('admin', function ($q) {
            $q->where('role', 'admin');
        });
    }
}
