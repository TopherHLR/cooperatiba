<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'uniform' => [
                'name' => $this->uniform->name,
                'image_url' => $this->uniform->image_url,
                'price' => number_format($this->uniform->price, 2, '.', ''),
            ],
            'size' => $this->size,
            'quantity' => $this->quantity,
            'subtotal_price' => number_format($this->subtotal_price, 2, '.', ''),
        ];
    }
}