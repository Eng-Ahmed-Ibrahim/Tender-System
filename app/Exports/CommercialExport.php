<?php

namespace App\Exports;

use App\Models\CommercialAd;
use App\Models\NormalAds;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CommercialExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        // Eager load the 'customer' relationship
        return CommercialAd::with('customer','category')
            ->get()
            ->map(function($ad) {
                return [
                    'Ad ID'      => $ad->id,
                    'Ad Title'   => $ad->title,
                    'Customer'   => $ad->customer ? $ad->customer->name : 'No Customer',
                    'category'   => $ad->category ? $ad->category->title : 'No category',
                    'Created At' => Carbon::parse($ad->created_at)->diffForHumans(),

                ];
            });
    }

    public function headings(): array
    {
        return [
            'Ad ID',
            'Ad Title',
            'Customer Name',
            'Catgory',
            'Created At',
        ];
    }

    public function title(): string
    {
        return 'User Data'; // Title for the Excel sheet
    }

    public function styles(Worksheet $sheet)
    {
        // Set the style for the header row
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => 'FFB6D7F7', // Hex color code for light blue
                    ],
                ],
            ],
        ];
    }
}
