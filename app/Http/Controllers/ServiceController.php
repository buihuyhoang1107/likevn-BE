<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Server;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::where('is_active', true);

        // Tìm kiếm theo keyword (name, description)
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter theo category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $services = $query->with(['servers' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('name', 'asc')
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

    public function getServers(Request $request, $serviceId)
    {
        $query = Server::where('service_id', $serviceId)
            ->where('is_active', true);

        // Tìm kiếm theo keyword (name, code, description)
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter theo status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter theo price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price_per_unit', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price_per_unit', '<=', $request->max_price);
        }

        $servers = $query->orderBy('price_per_unit', 'asc')->get();

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

        // Validate quantity divisible by 100 for telegram_post_view Server 1
        $service = $server->service;
        if ($service && $service->category === 'telegram_post_view') {
            // Check if this is Server 1 (có thể check bằng server code hoặc features)
            $isServer1 = $server->code === '475392' || 
                        (isset($server->features['requires_divisible_by_100']) && $server->features['requires_divisible_by_100'] === true) ||
                        (strpos(strtolower($server->name), 'server 1') !== false && strpos(strtolower($server->name), 'server 1') === 0);
            
            if ($isServer1 && $request->quantity % 100 !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng mua phải chia hết cho 100 (ví dụ: 500, 600, 700...)',
                ], 400);
            }
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

