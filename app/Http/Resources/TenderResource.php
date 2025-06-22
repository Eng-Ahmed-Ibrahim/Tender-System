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
                'id' => $this->id,
                'title' => $this->title,  
                'title_ar' => $this->title_ar,  
                'description' => $this->description,  
                'description_ar' => $this->description_ar,
                'company' => $this->company->name,  
                'end_date' => $this->end_date,
                'first_insurance' => $this->first_insurance,
                'price' => $this->price, 
                'city' => $this->city, 
                'country' => $this->country, 
                'show_applicants' => $this->show_applicants,
                'download_QR' => route('tenders.download', $this->id), // Link to download the QR code
                'applicants_count' => $this->applicants()->count(), // Add the count of applicants
            ];
        }
    
}
