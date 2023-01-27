<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function fetchData() {
        $data = DB::table('migrations')->get();
        return view('index', compact('data'));
    }
}
