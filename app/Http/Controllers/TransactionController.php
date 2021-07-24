<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class TransactionController extends Controller
{
    public function checkout()
    {
        // Tampilkan checkout yang statusnya pending
        $myCart = DB::table('carts')
            ->Join('items', 'items.id', '=', 'carts.id_item')
            ->where('carts.id_user', auth()->user()->id)
            ->where('status', 'no')
            ->select(
                'items.item_name',
                'items.item_image',
                'items.item_stock',
                'items.price',
                'items.item_description',
                'items.id AS id_item',
                'carts.count',
                'carts.id AS id_cart'
            )
            ->get();
        return view('transactions.checkout', compact('myCart'));
    }

    public function makeTrx(Request $request)
    {
        // Cek duplicate trx
        $cekTrxPending =
            DB::table('transactions')
            ->where('id_user', auth()->user()->id)
            ->where('status', 'pending')
            ->get();
        if (count($cekTrxPending) == 0) {
        } else {
            DB::table('transactions')
                ->where('id_user', '=', auth()->user()->id)
                ->where('status', '=', 'pending')
                ->delete();
        }
        // end cek
        $noTrx = DB::table('transactions')
            ->get();
        $arrValue = array();
        foreach ($noTrx as $key => $value) {
            array_push($arrValue, $value->no_trx);
        }
        if (count($noTrx) > 0) {
            $data = $request->all();
            if (count($data['id_item']) > 0) {
                foreach ($data['id_item'] as $key => $value) {
                    $data2 = array(
                        'id_user' => auth()->user()->id,
                        'id_cart' => $data['id_cart'][$key],
                        'id_item' => $data['id_item'][$key],
                        'price' => $data['price'][$key],
                        'count' => $data['count'][$key],
                        'status' => $data['status'][$key],
                        'no_trx' => max($arrValue) + 1,
                    );
                    Transaction::create($data2);
                }
                return redirect('/transactions');
            } else {
                return 'fail';
            }
        } else {
            $data = $request->all();
            if (count($data['id_item']) > 0) {
                foreach ($data['id_item'] as $key => $value) {
                    $data2 = array(
                        'id_user' => auth()->user()->id,
                        'id_cart' => $data['id_cart'][$key],
                        'id_item' => $data['id_item'][$key],
                        'price' => $data['price'][$key],
                        'count' => $data['count'][$key],
                        'status' => $data['status'][$key],
                        'no_trx' => 1,
                    );
                    Transaction::create($data2);
                }
                return redirect('/transactions');
            } else {
                return 'fail';
            }
        }
    }

    public function history()
    {
        // Ambil semua data dari tabel transaksi, filter by id user ambil yang statusnya success (untuk buyer)
        $trxs = DB::table('transactions')
            ->join('items', 'items.id', '=', 'transactions.id_item')
            ->join('users', 'users.id', '=', 'items.id_user')
            ->select(
                'transactions.id',
                'transactions.id_user as buyer',
                'users.id as seller',
                'transactions.id_item',
                'transactions.price',
                'transactions.count',
                'transactions.status',
                'transactions.no_trx',
                'transactions.created_at',
                'items.item_name',
                'items.item_image',
                'items.item_description',
                'users.username',
            )
            ->where('transactions.id_user', auth()->user()->id)
            ->where('transactions.status', 'success')
            ->get()
            ->sortBy('no_trx');
        // Ambil semua data dari tabel transaksi, filter by id user ambil yang statusnya success (untuk seller)
        $seller = DB::table('transactions')
            ->join('items', 'items.id', '=', 'transactions.id_item')
            ->join('users', 'users.id', '=', 'items.id_user')
            ->select(
                'transactions.id',
                'transactions.id_user as buyer',
                'users.id as seller',
                'transactions.id_item',
                'transactions.price',
                'transactions.count',
                'transactions.status',
                'transactions.no_trx',
                'transactions.created_at',
                'items.item_name',
                'items.item_image',
                'items.item_description',
            )
            ->where('users.id', auth()->user()->id)
            ->where('transactions.status', 'success')
            ->get()
            ->sortBy('no_trx');
        return view('transactions.list', compact('trxs', 'seller'));
    }
    public function show()
    {
        // Ambil semua data dari tabel transaksi, filter by id user dengan status pending
        $cekTrx = DB::table('transactions')
            ->where('id_user', auth()->user()->id)
            ->where('status', 'pending')
            ->get();
        if (count($cekTrx) > 0) {
            $trx = DB::table('items')
                ->join('transactions', 'transactions.id_item', '=', 'items.id')
                ->join('users', 'users.id', '=', 'items.id_user')
                ->where('transactions.id_user', auth()->user()->id)
                ->where('transactions.status', 'pending')
                ->select('items.item_name', 'items.item_description', 'items.item_image', 'items.price', 'transactions.count', 'transactions.status', 'users.username')
                ->get();
            if (count($trx) > 0) {
                $newPrice = 0;
                foreach ($trx as $t) {
                    $newPrice = $newPrice + ($t->price * $t->count);
                }
            }
            return view('transactions.show', compact('trx', 'newPrice', 'cekTrx'));
        } else {
            return view('transactions.show', compact('cekTrx'));
        }
    }

    public function pay(Request $request)
    {
        // ambil nilai price tiap item
        $total =
            DB::table('items')
            ->Join('transactions', 'transactions.id_item', '=', 'items.id')
            ->where('transactions.id_user', auth()->user()->id)
            ->where('transactions.status', 'pending')
            ->select('items.price', 'transactions.count')
            ->get();

        // ambil new price
        if (count($total) > 0) {
            $newPrice = 0;
            foreach ($total as $key => $value) {
                for ($i = 0; $i < $value->count; $i++) {
                    $newPrice += $value->price;
                }
            }
        }

        // validasi harus diisi dan minimal pay = newPrice
        $request->validate([
            'pay' => 'required',
        ]);

        // Cek apakah uang pada profile >= dengan newPrice (query dulu)
        $uangku = DB::table('users')
            ->where('id', auth()->user()->id)
            ->select('uang')
            ->get();
        if ($uangku[0]->uang < $newPrice || $request->pay < $newPrice) {
            return redirect('transactions')->with('status', 'Uang tidak cukup!');
        }

        $uangku[0]->uang = $uangku[0]->uang - $newPrice;
        // update profile (uang) kurangi dengan newPrice

        User::where('id', auth()->user()->id)->update([
            'uang' => $uangku[0]->uang
        ]);

        // ambil semua id item pada transaksi berdasarkan id pembeli
        $purchaseItem =  DB::table('transactions')
            ->where('id_user', auth()->user()->id)
            ->where('status', 'pending')
            ->select('id_item')
            ->get();

        // looping buat update si penjual
        foreach ($purchaseItem as $key => $value) {
            //  cari user penjual berdasakan id item
            $getInfoSeller = DB::table('users')
                ->Join('items', 'users.id', '=', 'items.id_user')
                ->Join('transactions', 'items.id', '=', 'transactions.id_item')
                ->where('transactions.id_item', $value->id_item)
                ->select('users.uang', 'users.username', 'transactions.price', 'items.id', 'transactions.count', 'items.item_stock', 'users.id AS id_user')
                ->get();
            $newValue = $getInfoSeller[0]->uang + ($getInfoSeller[0]->price * $getInfoSeller[0]->count);
            // update uang
            User::where('id', $getInfoSeller[0]->id_user)
                ->update(['uang' => $newValue]);

            $newStock = $getInfoSeller[0]->item_stock - $getInfoSeller[0]->count;

            // update stok
            Item::where('id', $getInfoSeller[0]->id)
                ->update(['item_stock' => $newStock]);
        }

        // ubah status pending berdasarkan id user menjadi success
        Transaction::where('id_user', auth()->user()->id)->update([
            'status' => 'success'
        ]);
        // ubah status no berdasarkan id user menjadi complete
        Cart::where('id_user', auth()->user()->id)->update([
            'status' => 'complete'
        ]);
        // redirect ke halaman awal dengan status pembelian berhasil
        return redirect('/')->with('status', 'Complete');
    }

    public function printBuyer(Request $request)
    {
        $customer = new Party([
            'name'          => auth()->user()->username,
            'address'       => auth()->user()->alamat
        ]);

        $item = DB::table('transactions')
            ->join('items', 'items.id', '=', 'transactions.id_item')
            ->join('users', 'users.id', '=', 'items.id_user')
            ->select(
                'items.price',
                'transactions.count',
                'items.item_name',
                'users.username',
            )
            ->where('transactions.no_trx', '=', $request->no_trx)
            ->get()
            ->toArray();

        $items = [];

        foreach ($item as $value) {
            array_push($items, (new InvoiceItem())->seller($value->username)->title($value->item_name)->pricePerUnit($value->price)->quantity($value->count));
        }

        $notes = ['Thank you for shopping.'];
        $notes = implode("<br>", $notes);
        $invoice = Invoice::make('ShopAja')
            ->sequence($request->no_trx)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->buyer($customer)
            ->isBuy(true)
            ->date(Carbon::parse($request->created_at))
            ->dateFormat('m-d-Y')
            ->currencySymbol('Rp ')
            ->currencyCode('IND')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($customer->name . '-' . time())
            ->addItems($items)
            ->notes($notes)
            ->save('public');

        return $invoice->stream();
    }
    public function printSeller(Request $request)
    {
        $customer = new Party([
            'name'          => auth()->user()->username,
            'address'       => auth()->user()->alamat
        ]);
        $item = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.id_user')
            ->join('items', 'items.id', '=', 'transactions.id_item')
            ->select(
                'items.price',
                'transactions.count',
                'items.item_name',
                'users.username',
            )
            ->where('transactions.no_trx', '=', $request->no_trx)
            ->get()
            ->toArray();
        $items = [];
        foreach ($item as $value) {
            array_push($items, (new InvoiceItem())->buyer($value->username)->title($value->item_name)->pricePerUnit($value->price)->quantity($value->count));
        }

        $invoice = Invoice::make('ShopAja')
            ->sequence($request->no_trx)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($customer)
            ->isBuy(false)
            ->date(Carbon::parse($request->created_at))
            ->dateFormat('m-d-Y')
            ->currencySymbol('Rp ')
            ->currencyCode('IND')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->filename($customer->name . '-' . time())
            ->addItems($items)
            ->save('public');
        return $invoice->stream();
    }
}
