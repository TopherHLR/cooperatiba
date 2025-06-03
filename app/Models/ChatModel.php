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
        'admin_id',
        'message',
        'timestamp',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id');
    }

    // If you have an Admin model:
    // public function admin()
    // {
    //     return $this->belongsTo(Admin::class, 'admin_id');
    // }
}