<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();

        return view('home', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        $request->validate([
            'id_user' => 'required',
            'item_name' => 'required',
            'item_description' => 'required',
            'item_stock' => 'required|min:0',
            'price' => 'required|min:0',
            'item_image' => 'required|mimes:png,jpg,jpeg|max:5048',
        ]);
        // create image name
        $newImageName = time() . '-' . $request->item_name . '.' . $request->item_image->extension();

        // save to public/images folder
        $request->item_image->move(public_path('images'), $newImageName);

        // save to database
        Item::create([
            'id_user' => $request->input('id_user'),
            'item_name' => $request->input('item_name'),
            'item_description' => $request->input('item_description'),
            'item_stock' => $request->input('item_stock'),
            'price' => $request->input('price'),
            'item_image' => $newImageName
        ]);

        // redirect
        return redirect('user/my-item')->with('status', 'Success Create New Item for Sell');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $itemSell = Item::find($item->id);
        $inCart = DB::table('carts')
            ->where('id_user', auth()->user()->id)
            ->where('id_item', $item->id)
            ->first();
        return view('items.detail', compact('itemSell', 'inCart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {

        if ($request->item_image) { // Ada gambar
            $request->validate([
                'id_user' => 'required',
                'item_name' => 'required',
                'item_description' => 'required',
                'item_stock' => 'required|min:0',
                'price' => 'required|min:0',
                'item_image' => 'required|mimes:png,jpg,jpeg|max:5048'
            ]);
            // delete old image
            unlink(public_path('images/' . $item->item_image));

            // create image name
            $newImageName = time() . '-' . $request->item_name . '.' . $request->item_image->extension();

            // save to public/images folder
            $request->item_image->move(public_path('images'), $newImageName);

            // edit with image
            Item::where('id', $item->id)->update([
                'id_user' => $request->input('id_user'),
                'item_name' => $request->input('item_name'),
                'item_description' => $request->input('item_description'),
                'item_stock' => $request->input('item_stock'),
                'price' => $request->input('price'),
                'item_image' => $newImageName
            ]);
        } else { // tidak ada gambar
            $request->validate([
                'id_user' => 'required',
                'item_name' => 'required',
                'item_description' => 'required',
                'item_stock' => 'required|min:0',
                'price' => 'required|min:0'
            ]);
            // edit without image
            Item::where('id', $item->id)->update([
                'id_user' => $request->input('id_user'),
                'item_name' => $request->input('item_name'),
                'item_description' => $request->input('item_description'),
                'item_stock' => $request->input('item_stock'),
                'price' => $request->input('price')
            ]);
        }
        return redirect('user/my-item')->with('status', 'Success Edit Item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        // delete image
        unlink(public_path('images/' . $item->item_image));
        // delete data
        Item::destroy($item->id);
        // redirect
        return redirect('user/my-item')->with('status', 'Success Delete Item');
    }

    // my item
    public function myItem()
    {
        $items = User::find(auth()->user()->id)->myItem;

        return view('items.index', compact('items'));
    }
}
