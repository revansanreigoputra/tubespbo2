<?php

namespace App\Http\Controllers\Api;

use App\Models\Pesanan;
use App\Http\Resources\PesananResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PesananUpdateHandler
{
    public function __invoke(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'jumlah_tiket' => 'required|integer',
            'total_harga'  => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pesanan = Pesanan::find($id);
        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        $pesanan->update([
            'id_pelanggan' => $request->id_pelanggan,
            'jumlah_tiket' => $request->jumlah_tiket,
            'total_harga'  => $request->total_harga,
        ]);

        return new PesananResource(true, 'Data Pesanan Berhasil Diubah!', $pesanan);
    }
}
