<?php

namespace App\Http\Controllers\Api;

use App\Models\Pesanan;
use App\Http\Resources\PesananResource;
use Illuminate\Http\Request;

class PesananShowHandler
{
    public function __invoke($id)
    {
        $pesanan = Pesanan::find($id);
        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }
        return new PesananResource(true, 'Detail Data Pesanan', $pesanan);
    }
}
