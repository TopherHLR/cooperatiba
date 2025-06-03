<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniformModel extends Model
{
    protected $table = 'uniform';
    protected $primaryKey = 'uniform_id';
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
}