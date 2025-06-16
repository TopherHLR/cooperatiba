<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'order_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'total_price',
        'order_date',
        'payment_status',
        'payment_method',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    // Relationships
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
     * Get the current status from the latest history record marked as current
     */
    public function getCurrentStatusAttribute(): string
    {
        $current = $this->statusHistories()->where('is_current', true)->first();
        return $current ? $current->status : 'pending';
    }

    /**
     * Get only the current status history record
     */
    public function currentStatusHistory()
    {
        return $this->hasOne(OrderHistoryModel::class, 'order_id', 'order_id')
            ->where('is_current', true);
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
            'completed' => [],
            'cancelled' => [],
        ];

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
     * Add a new status history record and mark it as current
     */
    public function recordStatusChange(string $newStatus, int $userId): OrderHistoryModel
    {
        // Reset all existing status records
        $this->statusHistories()->update(['is_current' => false]);

        // Create new one marked as current
        return $this->statusHistories()->create([
            'status' => $newStatus,
            'updated_by' => $userId,
            'updated_at' => now(),
            'is_read' => 0,
            'is_current' => 1,
        ]);
    }
}
