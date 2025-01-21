<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "total_price" => $this->total_price,
            "total_quantity" => $this->total_quantity,
            "items" => OrderItemResource::collection($this->orderItems),
            "created_at" => Carbon::parse($this->created_at)->shortRelativeToNowDiffForHumans(),

        ];
    }
}
