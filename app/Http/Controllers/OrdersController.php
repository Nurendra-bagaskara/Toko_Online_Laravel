<?php

namespace App\Http\Controllers;
use App\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function show()
    {
        return Orders::all();
    }
    public function detail($id)
    {
        if(Orders::where('id_orders', $id)->exists()) {
            $data_orders = Orders::join('customers', 'customers.id_customer', 'orders.id_customer')->join('product', 'product.id_product', 'orders.id_product')
            ->where('orders.id_orders', '=', $id)
            ->select('orders.*', 'customers.nama', 'product.nama_product')
            ->get();
            return Response()->json($data_orders);
        }
        else {
            return Response()->json(['message' => 'Tidak ditemukan' ]);
        }
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'id_customer' => 'required',
                'id_product' => 'required',
                'tgl_order' => 'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = Orders::create([
            'id_customer' => $request->id_customer,
            'id_product' => $request->id_product,
            'tgl_order' => $request->tgl_order
        ]);

        if($simpan)
        {
            return Response()->json(['status' => 1]);
        }

        else
        {   
            return Response()->json(['status' => 0]);
        }
    }

    public function update($id, Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'id_customer' => 'required',
                'id_product' => 'required',
                'tgl_order' => 'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = Orders::where ("id_orders", $id)->update([
            'id_customer' => $request->id_customer,
            'id_product' => $request->id_product,
            'tgl_order' => $request->tgl_order
        ]);

        if($simpan)
        {
            return Response()->json(['status' => 1]);
        }

        else
        {   
            return Response()->json(['status' => 0]);
        }
    }

    public function destroy($id)
    {
        $hapus = Orders::where('id_orders', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}
