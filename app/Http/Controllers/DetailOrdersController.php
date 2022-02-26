<?php

namespace App\Http\Controllers;
use App\DetailOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailOrdersController extends Controller
{
    public function show()
    {
        return DetailOrders::all();
    }
    public function detail($id)
    {
        if(DetailOrders::where('id_detail_orders', $id)->exists()) {
            $data_detail_orders = DetailOrders::join('orders', 'orders.id_orders', 'detail_orders.id_orders')->join('product', 'product.id_product', 'detail_orders.id_product')
            ->where('detail_orders.id_detail_orders', '=', $id)
            ->select('detail_orders.*', 'orders.tgl_order', 'product.nama_product')
            ->get();
            return Response()->json($data_detail_orders);
        }
        else {
            return Response()->json(['message' => 'Tidak ditemukan' ]);
        }
    }
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'id_orders' => 'required',
                'id_product' => 'required',
                'qty' => 'required',
                'subtotal' => 'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = DetailOrders::create([
            'id_orders' => $request->id_orders,
            'id_product' => $request->id_product,
            'qty' => $request->qty,
            'subtotal' => $request->subtotal
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
                'id_orders' => 'required',
                'id_product' => 'required',
                'qty' => 'required',
                'subtotal' => 'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = DetailOrders::where ("id_detail_orders", $id)->update([
            'id_orders' => $request->id_orders,
            'id_product' => $request->id_product,
            'qty' => $request->qty,
            'subtotal' => $request->subtotal
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
        $hapus = DetailOrders::where('id_detail_orders', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}
