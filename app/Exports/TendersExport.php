<?php
namespace App\Exports;

use App\Models\Tender;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class TendersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $tenders;

    /**
     * Constructor to accept filtered tenders collection
     * 
     * @param \Illuminate\Database\Eloquent\Collection $tenders
     */
    public function __construct($tenders = null)
    {
        $this->tenders = $tenders;
    }

    /**
     * Return the collection of tenders
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collection()
    {
        // If tenders are provided, use them; otherwise fetch all
        return $this->tenders ?? Tender::all();
    }

    /**
     * Define the headings for the export
     * 
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Company',
            'End Date',
            'First Insurance',
            'Price',
            'City',
            'Status'
        ];
    }

    /**
     * Map the data for each row
     * 
     * @param Tender $tender
     * @return array
     */
    public function map($tender): array
    {
        // Format the status based on the end date
        $status = now()->gt($tender->end_date) ? 'Closed' : 'Open';
        
        return [
            $tender->id,
            $tender->title,
            $tender->company->name ?? 'N/A', // Include company name
            $tender->end_date,
            $tender->first_insurance,
            $tender->price,
            $tender->city,
            $status
        ];
    }
}