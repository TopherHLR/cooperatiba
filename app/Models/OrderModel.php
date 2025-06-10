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
    
    //relationships
    public function student()
    {
        return $this->belongsTo(StudentModel::class, 'student_id', 'student_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItemModel::class, 'order_id');
    }

    public function processedOrder()
    {
        return $this->hasOne(ProcessedOrderModel::class, 'order_id');
    }
    public function statusHistories()
    {
        return $this->hasMany(OrderHistoryModel::class, 'order_id', 'order_id');
    }
        /**
     * Get the current status from the latest history record
     */
    public function getCurrentStatusAttribute(): string
    {
        $latestHistory = $this->statusHistories()->latest('updated_at')->first();
        return $latestHistory ? $latestHistory->status : 'pending';
    }

    /**
     * Check if a status transition is valid
     */
    public function isValidStatusTransition(string $newStatus): bool
    {
        $currentStatus = strtolower($this->current_status);
        $newStatus = strtolower($newStatus);
        $allowedTransitions = [
            'pending' => ['paid', 'cancelled'],
            'paid' => ['processing', 'cancelled'],
            'processing' => ['readyforpickup', 'cancelled'],
            'readyforpickup' => ['completed', 'cancelled'],
            // Final states
            'completed' => [],
            'cancelled' => [],
        ];

        // Check if transition is allowed
        return in_array($newStatus, $allowedTransitions[$currentStatus] ?? []);
    }
    public function getAllowedTransitions(): array
    {
        $allowedTransitions = [
            'pending' => ['paid', 'cancelled'],
            'paid' => ['processing', 'cancelled'],
            'processing' => ['readyforpickup', 'cancelled'],
            'readyforpickup' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => [],
        ];
        
        return $allowedTransitions[$this->current_status] ?? [];
    }
    /**
     * Add a new status history record
     */
    public function recordStatusChange(string $newStatus, int $userId): OrderHistoryModel
    {
        return $this->statusHistories()->create([
            'status' => $newStatus,
            'updated_by' => $userId,
            'updated_at' => now()
        ]);
    }

}