<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommercialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' =>$this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category->title,
            'photo' => asset('storage/'.$this->photo_path),
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'created_time' => Carbon::parse($this->created_at)->diffForHumans(),


        ];


    }
}
