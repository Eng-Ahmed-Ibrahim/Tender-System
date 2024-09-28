<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class AdsExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
protected $ads;

public function __construct($ads)
{
$this->ads = $ads; // Assign the passed collection
}

public function collection()
{
return $this->ads->map(function($ad) {
return [
'Ad ID'      => $ad->id,
'Ad Title'   => $ad->title,
'Customer'   => $ad->customer ? $ad->customer->name : 'No Customer',
'Category'   => $ad->category ? $ad->category->title : 'No Category',
'Created At' => Carbon::parse($ad->created_at)->format('Y-m-d H:i:s'),
];
});
}

public function headings(): array
{
return [
'Ad ID',
'Ad Title',
'Customer Name',
'Category',
'Created At',
];
}

public function title(): string
{
return 'Filtered Ads Data';
}

public function styles(Worksheet $sheet)
{
return [
1 => [
'font' => [
'bold' => true,
'size' => 14,
],
'fill' => [
'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
'startColor' => [
'argb' => 'FFB6D7F7',
],
],
],
];
}
}
