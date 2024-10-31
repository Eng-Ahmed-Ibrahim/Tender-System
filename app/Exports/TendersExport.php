<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Tender;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TendersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Tender::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'title',
            'end_date',
            'first_insurance',
            'price',
            'city',
       
        ];
    }

    public function map($tender): array
    {
        return [
           $tender->id,
           $tender->title,
           $tender->end_date,
           $tender->first_insurance,
           $tender->price,
           $tender->city,
        ];
    }
}