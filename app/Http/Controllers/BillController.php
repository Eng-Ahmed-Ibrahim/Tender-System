<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = Bill::findOrFail($id);

        return view('backend.bills.show',compact('bill'));
        
    }
    public function printInvoice($id)
    {
        $bill = Bill::findOrFail($id); // Get the bill data
        $pdf = PDF::loadView('backend.bills.bill-pdf', compact('bill'));
    
        return $pdf->download('invoice-' . $bill->id . '.pdf'); // Download the PDF
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
