<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Resources\Json\JsonResource;

class TenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
    

        return [
            'title' => $this->title,
            'description' =>  $this->description,
            'company' => $this->company->name,
            'end_date' => $this->end_date,
            'first_insurance' => $this->first_insurance,
            'price' => $this->price,
            'city' => $this->city,
            'download_QR' => route('tenders.download', $this->id), // Link to download the QR code
        ];
    }
}
