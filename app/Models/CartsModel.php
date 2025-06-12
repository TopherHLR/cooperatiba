<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartsModel extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'uniform_id',
        'quantity',
        'size',
    ];

    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'user_id', 'user_id');
    }

    public function uniform()
    {
        return $this->belongsTo(UniformModel::class, 'uniform_id', 'uniform_id');
    }
}
