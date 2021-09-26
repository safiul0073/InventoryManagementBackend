<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource
{

    public function toArray($request)
    {
       return [
            "id" => $this->id,
            "name" => $this->name,
            "image" => $this->image,
            'category_id' => $this->category_id,
            'unit_id' => $this->unit_id,
            "category" => $this->category->name,
            "unit" => $this->unit->name,
            "description" => $this->description,
            "code" => $this->code,
            "price" => $this->price,
            "quantity" => $this->quantity,
            "alert_quantity" => $this->alert_quantity,
            "status" => $this->status
        ];
    }
}
