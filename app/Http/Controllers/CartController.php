<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class CartController extends Controller
{
    function index() {
        list($products, $cartItems) = Cart::getProductsAndCartItems();
        $total = 0;
        foreach ($products as $product) {
            $total += $product->price * $cartItems[$product->id]['quantity'];
           }
     
        $count = 0;
        $count = Cart::getCartItemsCount();

        return Inertia::render('Cart', [
            'cartItems' => $cartItems,
            'products' => $products,
            'total' => $total,
            'count' => $count
        ]);
    }

    public function add($product_id) {
        $product = Product::findOrFail($product_id);
        $id = Auth::id();
        $cartItem = CartItem::where(['user_id' => $id, 'product_id' => $product_id])->first();
        $quantity = 1;
        if($cartItem)  {
            $cartItem->quantity  += $quantity;
            $cartItem->update();
        } else {
            $data = [
                'user_id' => $id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ];
           
            CartItem::create($data);
        }
        
        
    }

    public function remove(Request $request, $product_id) 
    {
        $user_id = Auth::id();
        if($user_id) {
            $cartItem = CartItem::query()->where(['user_id' => $user_id, 'product_id' => $product_id])->first();
            if($cartItem) {
                $cartItem->delete();
            }

        } 
        
        // else {
        //     $cartItems = json_decode($request->cookie('cart_items', '[]', ), true);
        //     foreach($cartItems as $i => &$item) {
        //         if($item['product_id'] == $product->id) {
        //             array_splice($cartItems, $i, 1);
        //             break;
        //         }
        //     }
        // }
    }

    public function addQuantity(Request $request,$product_id) {
        $user = $request->user();
        if($user) {
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product_id])->first();
            if($cartItem)  {
                $cartItem->quantity  = $cartItem->quantity +1;
                $cartItem->update();
            }
        }
     }

     public function removeQuantity(Request $request,$product_id) {
        $user = $request->user();
        if($user) {
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product_id])->first();
            if($cartItem->quantity < 2){

                $cartItem->delete();
            } 
            if($cartItem)  {
               
                $cartItem->quantity  = $cartItem->quantity - 1;
                $cartItem->update();
                
            }
        }
     }
    public function updateQuantity(Request $request, Product $product) 
    {
        $quantity = (int) $request->post('quantity');
        $user = $request->user();
        if($user) {
            CartItem::where(['user_id' => $request->user()->id, 'product_id' => $product->id])->update(['quantity' => $quantity]);

            return response([
                'count' => Cart::getCartItemsCount(),
            ]);
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach($cartItems as $item) {
                if($item['product_id'] == $product->id) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }

    }
   
}
