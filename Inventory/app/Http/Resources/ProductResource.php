<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request){

        return [
            'id'=>$this->$id,
            'business_owner_id'=>$this->business_owner_id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),     
              
        ];
    }
}
