<?php

namespace App\Http\Controllers\Api;

use App\Models\Pesanan;
use App\Http\Resources\PesananResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesananStoreHandler
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'jumlah_tiket' => 'required|integer',
            'total_harga'  => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pesanan = Pesanan::create([
            'id_pelanggan' => $request->id_pelanggan,
            'jumlah_tiket' => $request->jumlah_tiket,
            'total_harga'  => $request->total_harga,
        ]);

        return new PesananResource(true, 'Data Pesanan Berhasil Ditambahkan!', $pesanan);
    }
}
