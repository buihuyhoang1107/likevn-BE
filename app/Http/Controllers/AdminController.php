<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!$request->user()->isAdmin()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền truy cập',
                ], 403);
            }
            return $next($request);
        });
    }

    // User Management
    public function getUsers(Request $request)
    {
        $users = User::where('id', '!=', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $users,
        ]);
    }

    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'nullable|email|max:255',
            'full_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'ref_code' => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
            'type' => 'required|in:user,agent,collaborator',
            'balance' => 'nullable|numeric|min:0',
            'is_verified' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'ref_code' => $request->ref_code,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'balance' => $request->balance ?? 0,
            'is_verified' => $request->is_verified ?? false,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tạo tài khoản thành công',
            'data' => $user,
        ], 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => ['sometimes', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => 'nullable|email|max:255',
            'full_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'ref_code' => 'nullable|string|max:255',
            'password' => 'sometimes|string|min:6',
            'type' => 'sometimes|in:user,agent,collaborator',
            'balance' => 'nullable|numeric|min:0',
            'monthly_deposit' => 'nullable|numeric|min:0',
            'level' => 'nullable|integer|min:1',
            'is_verified' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'username', 'email', 'full_name', 'phone', 'ref_code',
            'type', 'balance', 'monthly_deposit', 'level', 'is_verified', 'is_active'
        ]);

        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật tài khoản thành công',
            'data' => $user->fresh(),
        ]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa tài khoản thành công',
        ]);
    }

    // Order Management
    public function getOrders(Request $request)
    {
        $orders = Order::with(['user', 'service', 'server', 'admin'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    public function getOrder($id)
    {
        $order = Order::with(['user', 'service', 'server', 'admin'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'sometimes|in:pending,processing,completed,cancelled,failed',
            'admin_note' => 'nullable|string',
            'ran' => 'sometimes|integer|min:0',
        ]);

        $data = $request->only(['status', 'admin_note', 'ran']);

        if ($request->has('status') && $request->status === 'processing' && !$order->started_at) {
            $data['started_at'] = now();
        }

        $data['admin_id'] = $request->user()->id;

        $order->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật đơn hàng thành công',
            'data' => $order->fresh()->load(['user', 'service', 'server', 'admin']),
        ]);
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa đơn hàng thành công',
        ]);
    }
}

