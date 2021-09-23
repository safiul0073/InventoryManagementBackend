<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSell extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "invoice_no" => $this->invoice_no,
            "name" => $this->customer_name,
            "phone" => $this->customer_phone,
            'amount' => $this->total_amount,
            "items" => $this->itemsalse
        ];
    }
}
