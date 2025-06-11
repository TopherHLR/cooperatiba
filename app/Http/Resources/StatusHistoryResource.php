<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
