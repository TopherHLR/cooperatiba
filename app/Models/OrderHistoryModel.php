<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistoryModel extends Model
{
    protected $table = 'order_history';
    protected $primaryKey = 'history_id';
    public $timestamps = false; // Since you have updated_at as a manual column

    protected $fillable = [
        'order_id',
        'status',
        'updated_at',
        'updated_by',
        'is_current',
        'is_read'  // <-- Add this
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'is_read' => 'boolean'

    ];

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id');
    }
    // With this:
    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}