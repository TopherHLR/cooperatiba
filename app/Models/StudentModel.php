<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentModel extends Model
{
    use HasFactory;

    protected $table = 'student';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'int'; // or 'string' if not integer

    protected $fillable = [
        'student_id', 
        'user_id',
        'first_name',
        'last_name',
        'middle_initial',
        'student_number',
        'program',
        'year_level',
        'section',
        'phone_number',
        'address',
        'age',
        'gender',
        'email',
        'password',
        'height',
        'weight',
        'bmi',
        'role',
        'suggested_size',
    ];

    protected $hidden = [
        'password',
    ];
        protected $casts = [
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'year_level' => 'integer',
        'age' => 'integer',
    ];
        // Relationships
    public function orders()
    {
        return $this->hasMany(OrderModel::class, 'student_id', 'student_id');
    }

    public function chats()
    {
        return $this->hasMany(ChatModel::class, 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
