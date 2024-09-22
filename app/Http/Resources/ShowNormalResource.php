<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowNormalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currencyCode = $this->additional['currency_code'] ?? 'USD';

        return [
            'id' => $this->id,
            'title' => $this->title,
            'subcategory' => $this->category->title,
            'main_category' => optional($this->category->parent)->title,
            'price' => number_format($this->price, 2) . ' ' . $currencyCode,
            'currency_code' => $currencyCode,
            'location' => $this->address,
            'Featured photo' => asset('storage/'.$this->photo),

            'created_time' => Carbon::parse($this->created_at)->diffForHumans(),
            'images' => $this->images->map(function($image) {
                return [
                    'url' => asset('storage/' . $image->image_path)
                ];
            }),
           'cars' => $this->cars ? [
                'color' => $this->cars->color,
    'year' => $this->cars->year,
    'kilo_meters' => $this->cars->kilo_meters,
    'fuel_type' => $this->cars->fuel_type,
    'brand' => $this->cars->brands->title,
    'features' => $this->cars->features->isNotEmpty() ? $this->cars->features->map(function($feature) {
        return [
            'title' => $feature->title,
        ];
    })->toArray() : null,
] : null,

            'bikes' => $this->bikes ? [
                'model' => $this->bikes->model,
                'year' => $this->bikes->year,
                'kilo_meters' => $this->bikes->kilo_meters,
                'status' => $this->bikes->status,
           'features' => $this->bikes->features->isNotEmpty() ? $this->bikes->features->map(function($feature) {
                    return [
                        'title' => $feature->title,
                    ];
                })->toArray() : null,
            ] : null,
            'houses' => $this->houses ? [
                'room_no' => $this->houses->room_no,
                'area' => $this->houses->area,
                'view' => $this->houses->view,
                'building_no' => $this->houses->building_no,
                'history' => $this->houses->history,
                
'features' => $this->houses->features->isNotEmpty() ? $this->houses->features->map(function($feature) {
                    return [
                        'title' => $feature->title,
                    ];
                })->toArray() : null,
            ] : null,            'mobiles' => $this->mobiles ? [
                'storage' => $this->mobiles->storage,
                'ram' => $this->mobiles->ram,
                'screen_size' => $this->mobiles->disply_size,
                'sim_no' => $this->mobiles->sim_no,
            ] : null,
        ];
    }
}
