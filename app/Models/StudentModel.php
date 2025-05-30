<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;  // Change here
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentModel extends  Authenticatable  // Change here
{
    use HasFactory;
    protected $table = 'student'; // your table name, if different

    protected $fillable = [
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

    // 🔗 Relationship: Student belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
