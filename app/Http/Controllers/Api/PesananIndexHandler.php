<?php

namespace App\Http\Controllers\Api;

use App\Models\Pesanan;
use App\Http\Resources\PesananResource;
use Illuminate\Http\Request;

class PesananIndexHandler
{
    public function __invoke(Request $request)
    {
        $pesanans = Pesanan::latest()->paginate(5);
        return new PesananResource(true, 'List Data Pesanan', $pesanans);
    }
}
