<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniformModel extends Model
{
    use HasFactory;
    protected $table = 'uniform';
    protected $primaryKey = 'uniform_id';

    // Add these two:
    public $incrementing = false;    // tells Laravel the PK is NOT auto-incrementing
    protected $keyType = 'string';   // tells Laravel the PK is a string

    public $timestamps = false;

    protected $fillable = [
        'name',
        'size',
        'price',
        'stock_quantity',
        'description',
        'image_url',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    // Relationships
    public function orderItems()
    {
        return $this->hasMany(OrderItemModel::class, 'uniform_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Get the initials of the name (e.g., "Winter Sweater" → "WS")
            $words = preg_split('/\s+/', trim($model->name));
            $initials = strtoupper(collect($words)->map(fn($w) => $w[0])->implode(''));
    
            // Pad a random number from 1–999 to 3 digits
            $number = str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
    
            // Format the uniform_id
            $model->uniform_id = 'UNIF-' . $initials . '-' . $number;
        });
    }
}
