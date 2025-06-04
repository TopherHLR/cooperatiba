<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    // In OrderModel.php
    protected $primaryKey = 'order_id';
    public $incrementing = true; // if it's auto-incrementing
    protected $keyType = 'int';  // or 'string' if your IDs are like "ORD-0001"
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'total_price',
        'order_date',
        'payment_status',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItemModel::class, 'order_id');
    }

    public function processedOrder()
    {
        return $this->hasOne(ProcessedOrderModel::class, 'order_id');
    }
}