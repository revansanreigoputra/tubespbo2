<?php

namespace App\Http\Controllers\Api\Handlers;

use App\Http\Resources\PesananResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PesananStoreHandler
{
    public function handle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pelanggan' => 'required|exists:pelanggans,id',
            'jumlah_tiket' => 'required|integer',
            'total_harga'  => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $pdo = DB::connection()->getPdo();
            $sql = "INSERT INTO pesanans (id_pelanggan, jumlah_tiket, total_harga, created_at, updated_at) 
                    VALUES (:id_pelanggan, :jumlah_tiket, :total_harga, :created_at, :updated_at)";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':id_pelanggan' => $request->id_pelanggan,
                ':jumlah_tiket' => $request->jumlah_tiket,
                ':total_harga'  => $request->total_harga,
                ':created_at'   => now(),
                ':updated_at'   => now(),
            ]);

            $id = $pdo->lastInsertId();
            $pesanan = $pdo->query("SELECT * FROM pesanans WHERE id = $id")->fetch(\PDO::FETCH_ASSOC);

            return new PesananResource(true, 'Data Pesanan Berhasil Ditambahkan!', $pesanan);
        } catch (\PDOException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
