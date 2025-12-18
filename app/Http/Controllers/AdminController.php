<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Server;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
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
        $query = User::where('id', '!=', $request->user()->id);

        // Tìm kiếm theo keyword (username, email, full_name)
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('full_name', 'like', "%{$search}%");
            });
        }

        // Filter theo type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter theo is_active
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active === 'true' || $request->is_active === true);
        }

        // Filter theo is_verified
        if ($request->has('is_verified')) {
            $query->where('is_verified', $request->is_verified === 'true' || $request->is_verified === true);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

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
        $query = Order::with(['user', 'service', 'server', 'admin']);

        // Tìm kiếm theo keyword (uid, account_name, note)
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('uid', 'like', "%{$search}%")
                  ->orWhere('account_name', 'like', "%{$search}%")
                  ->orWhere('note', 'like', "%{$search}%")
                  ->orWhere('admin_note', 'like', "%{$search}%");
            });
        }

        // Filter theo status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter theo user_id
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter theo service_id
        if ($request->has('service_id') && $request->service_id) {
            $query->where('service_id', $request->service_id);
        }

        // Filter theo server_id
        if ($request->has('server_id') && $request->server_id) {
            $query->where('server_id', $request->server_id);
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

    // Service Management
    public function getServices(Request $request)
    {
        $query = Service::with(['servers']);

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

        // Filter theo platform (nhóm dịch vụ)
        if ($request->has('platform') && $request->platform) {
            $platform = strtolower($request->platform);
            $categories = $this->getCategoriesByPlatform($platform);
            
            if (!empty($categories)) {
                $query->whereIn('category', $categories);
            }
        }

        // Filter theo is_active
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active === 'true' || $request->is_active === true);
        }

        $services = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $services,
        ]);
    }

    public function getService($id)
    {
        $service = Service::with(['servers'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $service,
        ]);
    }

    public function createService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:like_post_speed,like_post_vip,sub_personal_fanpage,like_fanpage,like_comment,increase_comment,share_post,member_group,review_fanpage,checkin_fanpage,event_facebook,vip_like_monthly,vip_like_group_monthly,vip_comment_monthly,vip_eye_monthly,vip_view_monthly,vip_share_monthly,eye_live_view_video,friend_cleanup,instagram_like,instagram_comment,instagram_follow,instagram_view,instagram_live_eye,instagram_vip_like,instagram_vip_comment,threads_like,threads_follow,tiktok_like,tiktok_like_comment,tiktok_follow,tiktok_view,tiktok_comment,tiktok_share,tiktok_save,tiktok_live_like,tiktok_live_share,tiktok_live_comment,tiktok_live_eye,tiktok_live_pk,tiktok_vip_like,tiktok_vip_view,shopee_follow,shopee_love,shopee_like_review,shopee_live_eye,telegram_member_sub,telegram_post_view,telegram_post_reaction,youtube_like,youtube_view,youtube_view_400h,youtube_live_stream,youtube_like_400h,youtube_comment,youtube_like_comment,youtube_subscribe,twitter_like,twitter_follow,twitter_view,twitter_retweet,twitter_comment,twitter_live_stream,twitter_vip_like,twitter_vip_view,lazada_sub,google_map_create,google_map_rip,google_map_review',
            'is_active' => 'nullable|boolean',
        ]);

        $service = Service::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'category' => $request->category,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tạo dịch vụ thành công',
            'data' => $service->load('servers'),
        ], 201);
    }

    public function updateService(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'category' => 'sometimes|in:like_post_speed,like_post_vip,sub_personal_fanpage,like_fanpage,like_comment,increase_comment,share_post,member_group,review_fanpage,checkin_fanpage,event_facebook,vip_like_monthly,vip_like_group_monthly,vip_comment_monthly,vip_eye_monthly,vip_view_monthly,vip_share_monthly,eye_live_view_video,friend_cleanup,instagram_like,instagram_comment,instagram_follow,instagram_view,instagram_live_eye,instagram_vip_like,instagram_vip_comment,threads_like,threads_follow,tiktok_like,tiktok_like_comment,tiktok_follow,tiktok_view,tiktok_comment,tiktok_share,tiktok_save,tiktok_live_like,tiktok_live_share,tiktok_live_comment,tiktok_live_eye,tiktok_live_pk,tiktok_vip_like,tiktok_vip_view,shopee_follow,shopee_love,shopee_like_review,shopee_live_eye,telegram_member_sub,telegram_post_view,telegram_post_reaction,youtube_like,youtube_view,youtube_view_400h,youtube_live_stream,youtube_like_400h,youtube_comment,youtube_like_comment,youtube_subscribe,twitter_like,twitter_follow,twitter_view,twitter_retweet,twitter_comment,twitter_live_stream,twitter_vip_like,twitter_vip_view,lazada_sub,google_map_create,google_map_rip,google_map_review',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'description', 'category', 'is_active']);

        // Auto generate slug if name changed
        if ($request->has('name') && $request->name !== $service->name) {
            $data['slug'] = Str::slug($request->name);
        }

        $service->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật dịch vụ thành công',
            'data' => $service->fresh()->load('servers'),
        ]);
    }

    public function deleteService($id)
    {
        $service = Service::findOrFail($id);

        // Check if service has orders
        if ($service->orders()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa dịch vụ đã có đơn hàng. Vui lòng vô hiệu hóa thay vì xóa.',
            ], 400);
        }

        // Check if service has servers
        if ($service->servers()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa dịch vụ đã có server. Vui lòng xóa các server trước hoặc vô hiệu hóa dịch vụ.',
            ], 400);
        }

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa dịch vụ thành công',
        ]);
    }

    // Server Management
    public function getServers(Request $request)
    {
        $query = Server::with(['service']);

        // Tìm kiếm theo keyword (name, code, description)
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter theo service_id (ưu tiên cao nhất)
        if ($request->has('service_id') && $request->service_id) {
            $query->where('service_id', $request->service_id);
        } elseif ($request->has('platform') && $request->platform) {
            // Chỉ filter theo platform nếu không có service_id
            $platform = strtolower($request->platform);
            $categories = $this->getCategoriesByPlatform($platform);
            
            if (!empty($categories)) {
                // Lấy tất cả service_ids của platform này
                $serviceIds = Service::whereIn('category', $categories)->pluck('id');
                $query->whereIn('service_id', $serviceIds);
            } else {
                // Nếu platform không hợp lệ, trả về empty
                $query->where('id', 0); // Không có server nào
            }
        }

        // Filter theo status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter theo is_active
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active === 'true' || $request->is_active === true);
        }

        $perPage = $request->get('per_page', 20);
        $servers = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $servers,
        ]);
    }

    public function getServer($id)
    {
        $server = Server::with(['service'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $server,
        ]);
    }

    public function createServer(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:servers,code',
            'service_id' => 'required|exists:services,id',
            'description' => 'nullable|string',
            'price_per_unit' => 'required|numeric|min:0',
            'status' => 'nullable|in:active,slow,stopped',
            'min_quantity' => 'nullable|integer|min:1',
            'max_quantity' => 'nullable|integer|min:1',
            // Features fields - dễ sử dụng hơn
            'support_batch' => 'nullable|boolean',
            'support_livestream' => 'nullable|boolean',
            'quality' => 'nullable|string|in:high,medium,low',
            'warranty_days' => 'nullable|integer|min:0',
            'country' => 'nullable|string',
            'account_type' => 'nullable|string',
            'features' => 'nullable|array', // Hoặc có thể gửi features dạng object
            'is_active' => 'nullable|boolean',
        ]);

        // Validate max_quantity > min_quantity if both provided
        if ($request->has('max_quantity') && $request->has('min_quantity')) {
            if ($request->max_quantity < $request->min_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng tối đa phải lớn hơn số lượng tối thiểu',
                ], 400);
            }
        }

        // Build features từ các field riêng lẻ hoặc từ features object
        $features = null;
        if ($request->has('features') && is_array($request->features)) {
            // Nếu gửi features dạng object
            $features = $request->features;
        } else {
            // Build từ các field riêng lẻ
            $featuresArray = [];
            if ($request->has('support_batch')) $featuresArray['support_batch'] = $request->support_batch;
            if ($request->has('support_livestream')) $featuresArray['support_livestream'] = $request->support_livestream;
            if ($request->has('quality')) $featuresArray['quality'] = $request->quality;
            if ($request->has('warranty_days')) $featuresArray['warranty_days'] = $request->warranty_days;
            if ($request->has('country')) $featuresArray['country'] = $request->country;
            if ($request->has('account_type')) $featuresArray['account_type'] = $request->account_type;
            
            if (!empty($featuresArray)) {
                $features = $featuresArray;
            }
        }

        $server = Server::create([
            'name' => $request->name,
            'code' => $request->code,
            'service_id' => $request->service_id,
            'description' => $request->description,
            'price_per_unit' => $request->price_per_unit,
            'status' => $request->status ?? 'active',
            'min_quantity' => $request->min_quantity ?? 1,
            'max_quantity' => $request->max_quantity,
            'features' => $features,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tạo server thành công',
            'data' => $server->load('service'),
        ], 201);
    }

    public function updateServer(Request $request, $id)
    {
        $server = Server::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'code' => ['sometimes', 'string', 'max:255', Rule::unique('servers')->ignore($server->id)],
            'service_id' => 'sometimes|exists:services,id',
            'description' => 'nullable|string',
            'price_per_unit' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:active,slow,stopped',
            'min_quantity' => 'nullable|integer|min:1',
            'max_quantity' => 'nullable|integer|min:1',
            // Features fields - dễ sử dụng hơn
            'support_batch' => 'nullable|boolean',
            'support_livestream' => 'nullable|boolean',
            'quality' => 'nullable|string|in:high,medium,low',
            'warranty_days' => 'nullable|integer|min:0',
            'country' => 'nullable|string',
            'account_type' => 'nullable|string',
            'features' => 'nullable|array', // Hoặc có thể gửi features dạng object
            'is_active' => 'nullable|boolean',
        ]);

        // Validate max_quantity > min_quantity
        $minQty = $request->has('min_quantity') ? $request->min_quantity : $server->min_quantity;
        $maxQty = $request->has('max_quantity') ? $request->max_quantity : $server->max_quantity;
        
        if ($maxQty && $minQty && $maxQty < $minQty) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng tối đa phải lớn hơn số lượng tối thiểu',
            ], 400);
        }

        $data = [];
        
        // Update only provided fields
        if ($request->has('name')) $data['name'] = $request->name;
        if ($request->has('code')) $data['code'] = $request->code;
        if ($request->has('service_id')) $data['service_id'] = $request->service_id;
        if ($request->has('description')) $data['description'] = $request->description; // Cho phép set null
        if ($request->has('price_per_unit')) $data['price_per_unit'] = $request->price_per_unit;
        if ($request->has('status')) $data['status'] = $request->status;
        if ($request->has('min_quantity')) $data['min_quantity'] = $request->min_quantity;
        if ($request->has('max_quantity')) $data['max_quantity'] = $request->max_quantity;
        if ($request->has('is_active')) $data['is_active'] = $request->is_active;

        // Handle features - ưu tiên các field riêng lẻ, sau đó mới đến features object
        $featuresUpdated = false;
        
        // Đảm bảo features luôn là array
        $featuresArray = [];
        if ($server->features) {
            if (is_array($server->features)) {
                $featuresArray = $server->features;
            } elseif (is_string($server->features)) {
                // Nếu là JSON string, decode nó
                $decoded = json_decode($server->features, true);
                $featuresArray = is_array($decoded) ? $decoded : [];
            }
        }
        
        // Cập nhật từ các field riêng lẻ
        if ($request->has('support_batch')) {
            $featuresArray['support_batch'] = $request->support_batch;
            $featuresUpdated = true;
        }
        if ($request->has('support_livestream')) {
            $featuresArray['support_livestream'] = $request->support_livestream;
            $featuresUpdated = true;
        }
        if ($request->has('quality')) {
            $featuresArray['quality'] = $request->quality;
            $featuresUpdated = true;
        }
        if ($request->has('warranty_days')) {
            $featuresArray['warranty_days'] = $request->warranty_days;
            $featuresUpdated = true;
        }
        if ($request->has('country')) {
            $featuresArray['country'] = $request->country;
            $featuresUpdated = true;
        }
        if ($request->has('account_type')) {
            $featuresArray['account_type'] = $request->account_type;
            $featuresUpdated = true;
        }
        
        // Nếu gửi features object, sẽ override tất cả
        if ($request->has('features')) {
            if ($request->features === null || (is_array($request->features) && empty($request->features))) {
                $data['features'] = null;
            } else {
                $data['features'] = is_array($request->features) ? $request->features : null;
            }
        } elseif ($featuresUpdated) {
            // Nếu có update từ các field riêng lẻ
            $data['features'] = $featuresArray;
        }

        $server->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật server thành công',
            'data' => $server->fresh()->load('service'),
        ]);
    }

    public function deleteServer($id)
    {
        $server = Server::findOrFail($id);

        // Check if server has orders
        if ($server->orders()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa server đã có đơn hàng. Vui lòng vô hiệu hóa thay vì xóa.',
            ], 400);
        }

        $server->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa server thành công',
        ]);
    }

    // Settings Management
    public function getSettings()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'enable_balance_check' => config('settings.enable_balance_check', false),
            ],
        ]);
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'enable_balance_check' => 'required|boolean',
        ]);

        // Update .env file
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);
        
        $key = 'ENABLE_BALANCE_CHECK';
        $value = $request->enable_balance_check ? 'true' : 'false';
        
        // Check if key exists
        if (preg_match("/^{$key}=.*/m", $envContent)) {
            // Update existing key
            $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        } else {
            // Add new key
            $envContent .= "\n{$key}={$value}\n";
        }
        
        file_put_contents($envFile, $envContent);
        
        // Clear config cache
        Artisan::call('config:clear');

        return response()->json([
            'success' => true,
            'message' => $request->enable_balance_check 
                ? 'Đã bật kiểm tra số dư' 
                : 'Đã tắt kiểm tra số dư',
            'data' => [
                'enable_balance_check' => $request->enable_balance_check,
            ],
        ]);
    }

    /**
     * Lấy danh sách category theo platform
     */
    private function getCategoriesByPlatform($platform)
    {
        $platforms = [
            'facebook' => [
                'like_post_speed',
                'like_post_vip',
                'sub_personal_fanpage',
                'like_fanpage',
                'like_comment',
                'increase_comment',
                'share_post',
                'member_group',
                'review_fanpage',
                'checkin_fanpage',
                'event_facebook',
                'vip_like_monthly',
                'vip_like_group_monthly',
                'vip_comment_monthly',
                'vip_eye_monthly',
                'vip_view_monthly',
                'vip_share_monthly',
                'eye_live_view_video',
                'friend_cleanup',
            ],
            'instagram' => [
                'instagram_like',
                'instagram_comment',
                'instagram_follow',
                'instagram_view',
                'instagram_live_eye',
                'instagram_vip_like',
                'instagram_vip_comment',
            ],
            'threads' => [
                'threads_like',
                'threads_follow',
            ],
            'tiktok' => [
                'tiktok_like',
                'tiktok_like_comment',
                'tiktok_follow',
                'tiktok_view',
                'tiktok_comment',
                'tiktok_share',
                'tiktok_save',
                'tiktok_live_like',
                'tiktok_live_share',
                'tiktok_live_comment',
                'tiktok_live_eye',
                'tiktok_live_pk',
                'tiktok_vip_like',
                'tiktok_vip_view',
            ],
            'shopee' => [
                'shopee_follow',
                'shopee_love',
                'shopee_like_review',
                'shopee_live_eye',
            ],
            'telegram' => [
                'telegram_member_sub',
                'telegram_post_view',
                'telegram_post_reaction',
            ],
            'youtube' => [
                'youtube_like',
                'youtube_view',
                'youtube_view_400h',
                'youtube_live_stream',
                'youtube_like_400h',
                'youtube_comment',
                'youtube_like_comment',
                'youtube_subscribe',
            ],
            'twitter' => [
                'twitter_like',
                'twitter_follow',
                'twitter_view',
                'twitter_retweet',
                'twitter_comment',
                'twitter_live_stream',
                'twitter_vip_like',
                'twitter_vip_view',
            ],
            'lazada' => [
                'lazada_sub',
            ],
            'google' => [
                'google_map_create',
                'google_map_rip',
                'google_map_review',
            ],
        ];

        return $platforms[$platform] ?? [];
    }

    /**
     * Lấy danh sách các platform và thống kê
     */
    public function getPlatforms()
    {
        $platforms = [
            'facebook' => [
                'name' => 'Facebook',
                'label' => 'Quản lý dịch vụ Facebook',
                'categories' => $this->getCategoriesByPlatform('facebook'),
            ],
            'instagram' => [
                'name' => 'Instagram',
                'label' => 'Quản lý dịch vụ Instagram',
                'categories' => $this->getCategoriesByPlatform('instagram'),
            ],
            'threads' => [
                'name' => 'Threads',
                'label' => 'Quản lý dịch vụ Threads',
                'categories' => $this->getCategoriesByPlatform('threads'),
            ],
            'tiktok' => [
                'name' => 'TikTok',
                'label' => 'Quản lý dịch vụ TikTok',
                'categories' => $this->getCategoriesByPlatform('tiktok'),
            ],
            'shopee' => [
                'name' => 'Shopee',
                'label' => 'Quản lý dịch vụ Shopee',
                'categories' => $this->getCategoriesByPlatform('shopee'),
            ],
            'telegram' => [
                'name' => 'Telegram',
                'label' => 'Quản lý dịch vụ Telegram',
                'categories' => $this->getCategoriesByPlatform('telegram'),
            ],
            'youtube' => [
                'name' => 'YouTube',
                'label' => 'Quản lý dịch vụ YouTube',
                'categories' => $this->getCategoriesByPlatform('youtube'),
            ],
            'twitter' => [
                'name' => 'Twitter',
                'label' => 'Quản lý dịch vụ Twitter',
                'categories' => $this->getCategoriesByPlatform('twitter'),
            ],
            'lazada' => [
                'name' => 'Lazada',
                'label' => 'Quản lý dịch vụ Lazada',
                'categories' => $this->getCategoriesByPlatform('lazada'),
            ],
            'google' => [
                'name' => 'Google',
                'label' => 'Quản lý dịch vụ Google',
                'categories' => $this->getCategoriesByPlatform('google'),
            ],
        ];

        // Thêm thống kê số lượng services cho mỗi platform
        $result = [];
        foreach ($platforms as $key => $platform) {
            $totalServices = Service::whereIn('category', $platform['categories'])->count();
            $activeServices = Service::whereIn('category', $platform['categories'])
                ->where('is_active', true)
                ->count();
            $inactiveServices = $totalServices - $activeServices;

            $result[] = [
                'id' => $key,
                'name' => $platform['name'],
                'label' => $platform['label'],
                'total_services' => $totalServices,
                'active_services' => $activeServices,
                'inactive_services' => $inactiveServices,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }
}

