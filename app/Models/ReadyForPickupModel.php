<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadyForPickUpModel extends Model
{
    protected $table = 'ready_for_pickup_orders';
    protected $primaryKey = 'ready_id';
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'ready_date',
        'pickup_location'
    ];

    protected $casts = [
        'ready_date' => 'datetime'
    ];

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id');
    }
    // Optional: Relationship with admin who prepared the order
    public function preparedBy()
    {
        return $this->belongsTo(AdminModel::class, 'prepared_by', 'admin_id');
    }
    // Helper method to mark as picked up
    public function markAsPickedUp()
    {
        // You might want to create an order history record here
        return $this->delete(); // Or add a 'picked_up' status
    }
}