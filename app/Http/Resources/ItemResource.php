<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'item' => $this->name,
            'category' => $this->category->cat_name,
            'size' => $this->size,
            'qty' => $this->pivot->qty,
            'unit' => $this->unit->abbreviation,
            'date_taken' => $this->pivot->date,
        ];
    }
}
