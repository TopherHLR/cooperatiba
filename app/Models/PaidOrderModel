<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaidOrderModel extends Model
{
    protected $table = 'paid_orders'; // Table name in database
    protected $primaryKey = 'paid_id';  // Primary key (note: consider renaming to 'payment_id' for clarity)
    public $timestamps = false;       // Disable auto timestamps

    protected $fillable = [
        'order_id',
        'payment_date',
        'payment_method',
        'transaction_id',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
    ];

    /**
     * Relationship with the Order model
     */
    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id');
    }

    /**
     * Accessor for formatted payment date
     */
    public function getFormattedPaymentDateAttribute()
    {
        return $this->payment_date->format('M d, Y h:i A');
    }

    /**
     * Scope for successful payments
     */
    public function scopeSuccessful($query)
    {
        return $query->whereNotNull('transaction_id');
    }
    // In your PaidOrder model:
    protected static function booted()
    {
        static::created(function ($paidOrder) {
            $paidOrder->order->update(['payment_status' => 'paid']);
        });
    }
}