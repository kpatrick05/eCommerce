<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index() {

        return Inertia::render('Reports');

    }
    public function user() {

        $users = User::where('name', 'LIKE', '%Ton%')->get();

        return Inertia::render('ManageUsers', [
            'users' => $users
        ]);

    }
    public function products() {

        $products = Product::get();

        return Inertia::render('ManageProducts', [
            'products' => $products
        ]);

    }

    public function edit($id) {

        $product = Product::find($id);

        return Inertia::render('EditProduct', [
            'product' => $product
        ]);

    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'price' => 'required|integer',
        ]);

        
        $prodouctItem = Product::where(['id' => $request->id])->first();
        $prodouctItem->title = $request->title;
        $prodouctItem->slug =$request->slug;
        $prodouctItem->description = $request->description;
        $prodouctItem->price = $request->price;
        $prodouctItem->update();
        // sleep(1);

        return redirect()->route('products')->with('message', 'Product Updated Successfully');

    }
}
