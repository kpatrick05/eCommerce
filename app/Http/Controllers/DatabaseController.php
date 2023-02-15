<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use Inertia\Inertia;

class DatabaseController extends Controller
{
    // public function fetchDataById($id) {
    //     $data = DB::table('products')->find($id);
    //     return Inertia::render('Details/fetchDataById', [
    //         'data' => $data,
    //         'id' => $id
    //        ]);
    // }
    public function show() {
        return Inertia::render('Products', [
           'data' => Product::all()
          ]);
    }
    public function showById($id) {
        return Inertia::render('Details', [
            'product' => Product::findOrFail($id)
        ]);
    }
}
