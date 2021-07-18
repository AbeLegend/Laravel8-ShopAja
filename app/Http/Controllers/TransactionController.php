<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class TransactionController extends Controller
{
    public function checkout()
    {
        // Setiap checkout janga lupa hapus dulu data checkout yang sebelumnya jika terjadi checkout ulang afar tidak duplicate
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

    public function show()
    {
        // Ambil semua data dari tabel transaksi, filter by id user
        $getAllTrx = DB::table('transactions')
            ->where('id_user', auth()->user()->id)
            ->get();
        dd($getAllTrx);
        // Pisahkan yang status success dan pending

        // Pastikan yang diambil no transaksi nya sama (1 card isinya semua trx yang no_trx sama)

        // Cek juga kalau ada transaksi atau ngga pakai count()->kalau ga ada sama sekali return kosong ke view

        // Tampilkan kedua data transaksi yang memiliki status pending dan sukses dalam 2 variable nanti kirim ke view juga 2 variale untuk statusnya

        // di view jadikan 2 card, 1 untuk pending (harus dibayar dulu), 1 lagi semua transaksi yang pernah ada yang sudah sukses disimpan
        // kedalam card sesuai no trx (ingat selalu cek kondisi pada view jika tidak ada transaksi agar tidak ada bug)

        // jangan lupa tampilkan button print untuk trx yang sukses. untuk pembeli munculkan pay under date untuk penjual tidak usah



        // ini yang pending yang harus dibayar
        // $cekTrx = DB::table('transactions')
        //     ->where('id_user', auth()->user()->id)
        //     ->where('status', 'pending')
        //     ->get();
        // if (count($cekTrx) > 0) {
        //     $trx = DB::table('items')
        //         ->Join('transactions', 'transactions.id_item', '=', 'items.id')
        //         ->where('transactions.id_user', auth()->user()->id)
        //         ->where('transactions.status', 'pending')
        //         ->select('items.item_name', 'items.item_image', 'items.price', 'transactions.count', 'transactions.status')
        //         ->get();
        //     if (count($trx) > 0) {
        //         $newPrice = 0;
        //         foreach ($trx as $t) {
        //             $newPrice = $newPrice + ($t->price * $t->count);
        //         }
        //     }
        //     return view('transactions.show', compact('trx', 'newPrice', 'cekTrx'));
        // } else {
        //     return view('transactions.show', compact('cekTrx'));
        // }
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

    public function myTrx()
    {
        //
    }

    public function checkoutOne(Request $request)
    {
        // dd($request);
        // $client = new Party([
        //     'name'          => 'Mohamad Fikri Abu Bakar',
        //     'address'       => 'Bandung'
        // ]);

        // $customer = new Party([
        //     'name'          => 'Abe',
        //     'address'       => 'Jakarta'
        // ]);

        // $items = [(new InvoiceItem())->title('Service 1')->pricePerUnit(500000)->quantity(2)];

        // $notes = ['Thanks'];
        // $notes = implode("<br>", $notes);

        // $invoice = Invoice::make('ShopAja')
        //     ->sequence(667) // invoice harus uniq
        //     ->serialNumberFormat('{SEQUENCE}/{SERIES}')
        //     ->seller($client)
        //     ->buyer($customer)
        //     ->date(now()->subWeeks(3))
        //     ->dateFormat('m/d/Y')
        //     ->currencySymbol('Rp ')
        //     ->currencyCode('IND')
        //     ->currencyFormat('{SYMBOL}{VALUE}')
        //     ->currencyThousandsSeparator('.')
        //     ->currencyDecimalPoint(',')
        //     ->filename($client->name . '-' . $customer->name . '-' . time())
        //     ->addItems($items)
        //     ->notes($notes)
        //     // You can additionally save generated invoice to configured disk
        //     ->save('public');

        // // And return invoice itself to browser or have a different view
        // return $invoice->stream();
    }
}
