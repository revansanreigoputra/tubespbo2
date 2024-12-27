<?php

namespace App\Http\Controllers\Api\Handlers;

use App\Http\Resources\PesananResource;
use Illuminate\Support\Facades\DB;

class PesananIndexHandler
{
    public function handle()
    {
        try {
            $pdo = DB::connection()->getPdo();
            $sql = "SELECT * FROM pesanans ORDER BY id DESC LIMIT 5";
            $stmt = $pdo->query($sql);
            $pesanans = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return new PesananResource(true, 'List Data Pesanan', $pesanans);
        } catch (\PDOException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
