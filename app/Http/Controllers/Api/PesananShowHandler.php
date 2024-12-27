<?php

namespace App\Http\Controllers\Api\Handlers;

use App\Http\Resources\PesananResource;
use Illuminate\Support\Facades\DB;

class PesananShowHandler
{
    public function handle($id)
    {
        try {
            $pdo = DB::connection()->getPdo();

            // Ambil data pesanan berdasarkan ID
            $sql = "SELECT * FROM pesanans WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
            $pesanan = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$pesanan) {
                return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
            }

            return new PesananResource(true, 'Detail Data Pesanan', $pesanan);
        } catch (\PDOException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
