<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class ProductController extends Controller
{
    public function show()
    {
        return Product::all();
    }

    public function detail($id)
    {
        if(Product::where('id_product', $id)->exists()) {
            $data_product = DB::table('product')
            ->select('product.*')
            ->where('product.id_product', '=', $id)
            ->get();
            return Response()->json($data_product);
        }
        else 
        {
        return Response()->json(['message' => 'Tidak ditemukan' ]);
        }
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),
            [
                'nama_product' => 'required',
                'deskripsi' => 'required',
                'harga' => 'required',
                'foto_product' => 'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = Product::create([
            'nama_product' => $request->nama_product,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'foto_product' => $request->foto_product
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
                'nama_product' => 'required',
                'deskripsi' => 'required',
                'harga' => 'required',
                'foto_product' => 'required'
            ]
        );

        if($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $simpan = Product::where("id_product", $id )->update([
            'nama_product' => $request->nama_product,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'foto_product' => $request->foto_product
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
        $hapus = Product::where('id_product', $id)->delete();
        if($hapus) {
            return Response()->json(['status' => 1]);
        }
        else {
            return Response()->json(['status' => 0]);
        }
    }
}

