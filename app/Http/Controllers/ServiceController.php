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

        // Filter theo platform (nhóm dịch vụ)
        if ($request->has('platform') && $request->platform) {
            $platform = strtolower($request->platform);
            $categories = $this->getCategoriesByPlatform($platform);
            
            if (!empty($categories)) {
                $query->whereIn('category', $categories);
            }
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
        // Check if service exists
        $service = Service::find($serviceId);
        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Dịch vụ không tồn tại',
            ], 404);
        }

        $query = Server::where('service_id', (int)$serviceId)
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
        ];

        return $platforms[$platform] ?? [];
    }
}

