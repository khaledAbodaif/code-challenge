<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            "product" => ProductResource::make($this->product),
            "quantity" => $this->quantity,
            "unit_price" => $this->unit_price,
            "total_price" => $this->total_price,
            "created_at" => Carbon::parse($this->created_at)->shortRelativeToNowDiffForHumans(),

        ];
    }
}
