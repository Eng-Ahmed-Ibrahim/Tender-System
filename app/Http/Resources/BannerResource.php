<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'category' => $this->category->title ?? 'N/A',
            'photo_url' => asset('storage/' . $this->photo_path),
            'country_name' => $this->country->name ?? 'N/A', 
            'view' => route('ApiBanners.show', $this->id),
            'created_time' => Carbon::parse($this->created_at)->diffForHumans(),
    ]; 
    }
}
