<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function normal(){

        $categories = Category::all();

        return view('backend.reports.index',compact(
            'categories'
        ));
    }
}
