<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    public $timestamps = false; // Assuming no created_at/updated_at columns

    protected $fillable = [
        'name',
        'email',
        'password',
        'node' // Assuming this is a permission node or department
    ];

    protected $hidden = [
        'password' // Always hide passwords
    ];

    // Relationship with Processed Orders
    public function processedOrders()
    {
        return $this->hasMany(ProcessedOrderModel::class, 'staff_assigned', 'admin_id');
    }

    // Relationship with Chats
    public function chats()
    {
        return $this->hasMany(ChatModel::class, 'admin_id');
    }

    // Relationship with Order History
    public function orderHistoryUpdates()
    {
        return $this->hasMany(OrderHistoryModel::class, 'updated_by');
    }
}