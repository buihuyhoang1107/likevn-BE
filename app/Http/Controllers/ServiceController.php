<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Server;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::where('is_active', true)
            ->with(['servers' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    }

    public function show($id)
    {
        $service = Service::with(['servers' => function ($query) {
            $query->where('is_active', true);
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $service,
        ]);
    }

    public function getServers($serviceId)
    {
        $servers = Server::where('service_id', $serviceId)
            ->where('is_active', true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $servers,
        ]);
    }

    public function calculatePrice(Request $request)
    {
        $request->validate([
            'server_id' => 'required|exists:servers,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $server = Server::findOrFail($request->server_id);

        if ($request->quantity < $server->min_quantity) {
            return response()->json([
                'success' => false,
                'message' => "Số lượng tối thiểu là {$server->min_quantity}",
            ], 400);
        }

        if ($server->max_quantity && $request->quantity > $server->max_quantity) {
            return response()->json([
                'success' => false,
                'message' => "Số lượng tối đa là {$server->max_quantity}",
            ], 400);
        }

        $totalPrice = $server->price_per_unit * $request->quantity;

        return response()->json([
            'success' => true,
            'data' => [
                'price_per_unit' => $server->price_per_unit,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
            ],
        ]);
    }
}

