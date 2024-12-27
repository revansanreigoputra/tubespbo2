<?php

namespace App\Http\Controllers\Api;

use App\Models\Pesanan;
use App\Http\Resources\PesananResource;

class PesananDestroyHandler
{
    public function __invoke($id)
    {
        $pesanan = Pesanan::find($id);
        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        $pesanan->delete();

        return new PesananResource(true, 'Data Pesanan Berhasil Dihapus!', null);
    }
}
