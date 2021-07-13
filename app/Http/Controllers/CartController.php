<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'id_item' => 'required',
            'count' => 'required|numeric|min:1',
        ]);

        Cart::create([
            'id_user' => $request->input('id_user'),
            'id_item' => $request->input('id_item'),
            'count' => $request->input('count'),
            'status' => 'no'
        ]);

        return redirect('items/' . $request->id_item)->with('status', 'Success Add to Cart');
    }
    public function destroy(Cart $cart)
    {
        // // delete data
        Cart::destroy($cart->id);
        // // redirect
        return redirect('items/' . $cart->id_item)->with('status', 'Success Delete From Cart');
    }

    public function show()
    {
        $myCart = DB::table('carts')
            ->Join('items', 'items.id', '=', 'carts.id_item')
            ->where('carts.id_user', auth()->user()->id)
            ->where('status', 'no')
            ->select(
                'items.item_name',
                'items.item_image',
                'items.price',
                'items.item_description',
                'items.id AS id_item',
                'carts.id AS id_cart'
            )
            ->get();
        return view('items.cart', compact('myCart'));
    }
    public function purchaseAmount(Request $request)
    {
        // dd($request->id_cart);
        $request->validate([
            'count' => 'required',
            'id_cart' => 'required',
        ]);
        Cart::where('id', $request->id_cart)->update([
            'count' => $request->input('count'),
        ]);
        return redirect('checkout');
    }
}
