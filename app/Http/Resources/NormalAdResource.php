<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\ConvertCurrency;
use Illuminate\Http\Resources\Json\JsonResource;

class NormalAdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $currencyCode = $this->additional['currency_code'] ?? 'USD';
        
        return [
            'id' => $this->id,
            'title' => $this->title,
            'subcategory' => $this->category->title,
            'main_category' => optional($this->category->parent)->title,
            //'customer' =>$this->customer->name,
            'price' => ConvertCurrency::convertPrice($this->price, $currencyCode),
            'Featured photo' => asset('storage/'.$this->photo),

            'currency_code' => $currencyCode,


            'location' =>$this->address ,
            'created_time' => Carbon::parse($this->created_at)->diffForHumans(),
        
        ];
    }
}
