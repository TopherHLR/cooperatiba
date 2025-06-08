<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessedOrderModel extends Model
{
    protected $table = 'processed_orders';
    protected $primaryKey = 'processed_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'processed_date',
        'staff_assigned',
    ];

    protected $casts = [
        'processed_date' => 'datetime',
    ];
    public function staffAssigned()
    {
        return $this->belongsTo(User::class, 'staff_assigned');
    }

    // Relationships
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id');
    }
}