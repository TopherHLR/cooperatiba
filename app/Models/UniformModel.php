<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniformModel extends Model
{
    protected $table = 'uniform'; // Make sure this matches the actual table name in your DB

    protected $primaryKey = 'uniform_id';

    public $timestamps = false; // Set to true if your table has created_at and updated_at columns

    protected $fillable = [
        'name',
        'size',
        'price',
        'stock_quantity',
        'description',
        'image_url',
    ];
}
