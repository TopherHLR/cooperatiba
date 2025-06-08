<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_item';
    protected $primaryKey = 'order_item_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'uniform_id',
        'quantity',
        'size',
        'subtotal_price',
    ];

    protected $casts = [
        'subtotal_price' => 'decimal:2',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id');
    }

    public function uniform()
    {
        return $this->belongsTo(UniformModel::class, 'uniform_id');
    }
}