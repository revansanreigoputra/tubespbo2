<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Handlers\PesananIndexHandler;
use App\Http\Controllers\Api\Handlers\PesananStoreHandler;
use App\Http\Controllers\Api\Handlers\PesananShowHandler;
use App\Http\Controllers\Api\Handlers\PesananUpdateHandler;
use App\Http\Controllers\Api\Handlers\PesananDestroyHandler;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        return app(PesananIndexHandler::class)->handle();
    }

    public function store(Request $request)
    {
        return app(PesananStoreHandler::class)->handle($request);
    }

    public function show($id)
    {
        return app(PesananShowHandler::class)->handle($id);
    }

    public function update(Request $request, $id)
    {
        return app(PesananUpdateHandler::class)->handle($request, $id);
    }

    public function destroy($id)
    {
        return app(PesananDestroyHandler::class)->handle($id);
    }
}
