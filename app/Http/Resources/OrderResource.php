<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'order_id' => $this->order_id,
            'order_date' => $this->order_date->format('Y-m-d H:i:s'),
            'total_price' => number_format($this->total_price, 2, '.', ''),
            'payment_status' => $this->payment_status,
            'order_items' => OrderItemResource::collection($this->orderItems),
            'status_histories' => StatusHistoryResource::collection($this->statusHistories),
        ];
    }
}