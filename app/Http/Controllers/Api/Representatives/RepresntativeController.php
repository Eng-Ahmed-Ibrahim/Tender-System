<?php

namespace App\Http\Controllers\Api\Representatives;

use Illuminate\Http\Request;
use App\Models\Representative;
use App\Http\Controllers\Controller;
use App\Http\Resources\RepresntResource;

class RepresntativeController extends Controller
{
    
    public function index()
    {
        $represntatives = Representative::all();

        return RepresntResource::collection($represntatives);

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
