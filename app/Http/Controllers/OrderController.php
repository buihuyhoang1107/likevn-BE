<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Server;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'server_id' => 'required|exists:servers,id',
            'uid' => 'nullable|string',
            'account_name' => 'nullable|string',
            'content' => 'nullable|string',
            'note' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'emotion' => 'nullable|string|in:like,love,haha,wow,sad,angry',
            'speed' => 'nullable|string|in:nhanh,cham,trung_binh',
        ]);

        $user = $request->user();
        $server = Server::findOrFail($request->server_id);
        $service = Service::findOrFail($request->service_id);

        // Validate server belongs to service
        if ($server->service_id !== $service->id) {
            return response()->json([
                'success' => false,
                'message' => 'Server không thuộc dịch vụ này',
            ], 400);
        }

        // Validate quantity
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

        // Calculate price
        $totalPrice = $server->price_per_unit * $request->quantity;

        // Check balance (only if enabled)
        $enableBalanceCheck = config('settings.enable_balance_check', false);
        
        if ($enableBalanceCheck) {
            if ($user->balance < $totalPrice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số dư không đủ',
                ], 400);
            }
        }

        DB::beginTransaction();
        try {
            // Deduct balance (only if enabled)
            if ($enableBalanceCheck) {
                $user->decrement('balance', $totalPrice);
            }

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'service_id' => $service->id,
                'server_id' => $server->id,
                'action' => $service->name,
                'uid' => $request->uid,
                'account_name' => $request->account_name,
                'content' => $request->content,
                'note' => $request->note,
                'quantity' => $request->quantity,
                'price_per_unit' => $server->price_per_unit,
                'total_price' => $totalPrice,
                'emotion' => $request->emotion,
                'speed' => $request->speed,
                'status' => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Tạo đơn hàng thành công',
                'data' => $order->load(['service', 'server']),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tạo đơn hàng',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function myOrders(Request $request)
    {
        $query = Order::where('user_id', $request->user()->id)
            ->with(['service', 'server']);

        // Tìm kiếm theo keyword (uid, account_name, note)
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('uid', 'like', "%{$search}%")
                  ->orWhere('account_name', 'like', "%{$search}%")
                  ->orWhere('note', 'like', "%{$search}%");
            });
        }

        // Filter theo status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter theo service_id
        if ($request->has('service_id') && $request->service_id) {
            $query->where('service_id', $request->service_id);
        }

        // Filter theo date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    public function show(Request $request, $id)
    {
        $order = Order::with(['service', 'server', 'user'])
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }
}

