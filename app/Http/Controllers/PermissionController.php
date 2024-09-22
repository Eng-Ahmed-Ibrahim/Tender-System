<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
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
        $permissions = Permission::all();
        return view ('backend.permissions.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:permissions,name',
        'group_name' => 'required|string|max:255|unique:permissions,name',
    ]);

    // إنشاء صلاحية جديدة
    $permission = Permission::create([
        'name' => $request->input('name'),
        'group_name' => $request->input('group_name'),
    ]);

    // إعادة الاستجابة بصيغة JSON
    return response()->json($permission, 201);
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
