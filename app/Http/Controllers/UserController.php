<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'username' => ['sometimes', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => 'nullable|email|max:255',
            'full_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'ref_code' => 'nullable|string|max:255',
            'password' => 'sometimes|string|min:6',
        ]);

        $data = $request->only(['username', 'email', 'full_name', 'phone', 'ref_code']);

        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công',
            'data' => $user->fresh(),
        ]);
    }

    public function getBalance(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'balance' => $request->user()->balance,
                'monthly_deposit' => $request->user()->monthly_deposit,
            ],
        ]);
    }
}

