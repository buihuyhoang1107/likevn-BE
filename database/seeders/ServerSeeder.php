<?php

namespace Database\Seeders;

use App\Models\Server;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    public function run()
    {
        // Like bài viết Speed
        $likePostSpeed = Service::where('slug', 'like-post-speed')->first();
        if ($likePostSpeed) {
            $servers = [
                ['name' => 'Server 6', 'code' => 'S6', 'price_per_unit' => 26.2, 'status' => 'active'],
                ['name' => 'Server 1', 'code' => 'S1', 'price_per_unit' => 14.2, 'status' => 'slow', 'description' => 'Tốc độ chậm'],
                ['name' => 'Server 3', 'code' => 'S3', 'price_per_unit' => 25, 'status' => 'active', 'description' => 'Tốc độ ổn'],
                ['name' => 'Server 5', 'code' => 'S5', 'price_per_unit' => 16, 'status' => 'active', 'description' => 'Tốc độ trung bình'],
                ['name' => 'Server 15', 'code' => 'S15', 'price_per_unit' => 38.2, 'status' => 'active'],
                ['name' => 'Server 16', 'code' => 'S16', 'price_per_unit' => 62.2, 'status' => 'active'],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $likePostSpeed->id,
                    'min_quantity' => 1,
                ]));
            }
        }

        // Like bài viết VIP
        $likePostVip = Service::where('slug', 'like-post-vip')->first();
        if ($likePostVip) {
            Server::create([
                'service_id' => $likePostVip->id,
                'name' => 'Server 1',
                'code' => 'VIP_S1',
                'price_per_unit' => 57.6,
                'status' => 'active',
                'description' => 'Tăng chậm',
                'min_quantity' => 1,
            ]);
        }

        // Sub cá nhân & Sub fanpage
        $subPersonal = Service::where('slug', 'sub-personal-fanpage')->first();
        if ($subPersonal) {
            $servers = [
                [
                    'name' => 'Server 3',
                    'code' => 'SUB_S3',
                    'price_per_unit' => 41.8,
                    'status' => 'active',
                    'description' => 'Sub Tên Việt Nam, tốc độ 2k/1 ngày, bảo hành 7 ngày. Hỗ trợ sub cá nhân & fanpage',
                    'min_quantity' => 100,
                    'max_quantity' => 40000,
                ],
                [
                    'name' => 'Server 4',
                    'code' => 'SUB_S4',
                    'price_per_unit' => 29.6,
                    'status' => 'active',
                    'description' => 'Sub Tên Việt Nam, tốc độ 2k/1 ngày, bảo hành 7 ngày',
                    'min_quantity' => 100,
                    'max_quantity' => 40000,
                ],
                [
                    'name' => 'Server 6',
                    'code' => 'SUB_S6',
                    'price_per_unit' => 36,
                    'status' => 'active',
                    'description' => 'Sub Tây, tốc độ 20k/1 ngày, bảo hành 7 ngày',
                    'min_quantity' => 100,
                    'max_quantity' => 40000,
                ],
                [
                    'name' => 'Server 7',
                    'code' => 'SUB_S7',
                    'price_per_unit' => 29.9,
                    'status' => 'active',
                    'description' => 'Sub Tây, tốc độ 10k/1 ngày, bảo hành 7 ngày',
                    'min_quantity' => 100,
                    'max_quantity' => 40000,
                ],
                [
                    'name' => 'Server 8',
                    'code' => 'SUB_S8',
                    'price_per_unit' => 16.2,
                    'status' => 'active',
                    'description' => 'Sub Tây, tốc độ 30k/1 ngày, bảo hành 7 ngày',
                    'min_quantity' => 100,
                    'max_quantity' => 40000,
                ],
                [
                    'name' => 'Server 11',
                    'code' => 'SUB_S11',
                    'price_per_unit' => 25.8,
                    'status' => 'stopped',
                    'description' => 'Sub Việt Nam, tốc độ 5k/1 ngày, bảo hành 7 ngày',
                    'min_quantity' => 100,
                    'max_quantity' => 40000,
                ],
                [
                    'name' => 'Server 12',
                    'code' => 'SUB_S12',
                    'price_per_unit' => 50.4,
                    'status' => 'stopped',
                    'description' => 'Sub Việt Nam, tốc độ 10k/1 ngày, bảo hành 7 ngày',
                    'min_quantity' => 100,
                    'max_quantity' => 40000,
                ],
                [
                    'name' => 'Server 15',
                    'code' => 'SUB_S15',
                    'price_per_unit' => 65.8,
                    'status' => 'stopped',
                    'description' => 'Sub Việt Nam, tốc độ 30k/1 ngày, bảo hành 7 ngày',
                    'min_quantity' => 100,
                    'max_quantity' => 40000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $subPersonal->id,
                    'min_quantity' => $server['min_quantity'] ?? 1,
                    'max_quantity' => $server['max_quantity'] ?? null,
                ]));
            }
        }

        // Like fanpage
        $likeFanpage = Service::where('slug', 'like-fanpage')->first();
        if ($likeFanpage) {
            $servers = [
                ['name' => 'Server 2', 'code' => 'FP_S2', 'price_per_unit' => 34.3, 'status' => 'active', 'description' => 'Like Ngoại, tốc độ 10k/1 ngày. Bảo hành 7 ngày', 'min_quantity' => 100, 'max_quantity' => 20000],
                ['name' => 'Server 4', 'code' => 'FP_S4', 'price_per_unit' => 52.6, 'status' => 'slow', 'description' => 'Like Random, tốc độ 500/1 ngày. Bảo hành 7 ngày', 'min_quantity' => 1],
                ['name' => 'Server 5', 'code' => 'FP_S5', 'price_per_unit' => 38.2, 'status' => 'active', 'description' => 'Like tên Việt Nam, tốc độ 20k/1 ngày. Bảo hành 7 ngày', 'min_quantity' => 1],
                ['name' => 'Server 10', 'code' => 'FP_S10', 'price_per_unit' => 57.6, 'status' => 'slow', 'description' => 'Like Việt Nam, tốc độ 500/1 ngày. Bảo hành 7 ngày', 'min_quantity' => 1],
                ['name' => 'Server 11', 'code' => 'FP_S11', 'price_per_unit' => 32.4, 'status' => 'active', 'description' => 'Like Việt Nam, tốc độ 10k/1 ngày. Không bảo hành', 'min_quantity' => 1],
                ['name' => 'Server 12', 'code' => 'FP_S12', 'price_per_unit' => 50.4, 'status' => 'active', 'description' => 'Like Việt Nam, tốc độ 20k/1 ngày. Không bảo hành', 'min_quantity' => 1],
                ['name' => 'Server 15', 'code' => 'FP_S15', 'price_per_unit' => 65.8, 'status' => 'active', 'description' => 'Like Việt Nam, tốc độ 30k/1 ngày. Không bảo hành', 'min_quantity' => 1],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $likeFanpage->id,
                ]));
            }
        }

        // Like cho bình luận
        $likeComment = Service::where('slug', 'like-comment')->first();
        if ($likeComment) {
            $servers = [
                ['name' => 'Server 3', 'code' => 'LC_S3', 'price_per_unit' => 50.4, 'status' => 'active', 'description' => 'Like việt', 'min_quantity' => 50, 'max_quantity' => 50000, 'features' => json_encode(['support_batch' => true])],
                ['name' => 'Server 4', 'code' => 'LC_S4', 'price_per_unit' => 27.4, 'status' => 'active', 'description' => 'Like việt', 'min_quantity' => 1],
                ['name' => 'Server 5', 'code' => 'LC_S5', 'price_per_unit' => 70.8, 'status' => 'active', 'description' => 'Tốc độ tốt', 'min_quantity' => 1],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $likeComment->id,
                ]));
            }
        }

        // Tăng bình luận
        $increaseComment = Service::where('slug', 'increase-comment')->first();
        if ($increaseComment) {
            $servers = [
                ['name' => 'Server 5', 'code' => 'IC_S5', 'price_per_unit' => 600, 'status' => 'active', 'description' => 'Việt Nam. Tốc độ nhanh', 'min_quantity' => 10, 'max_quantity' => 500, 'features' => json_encode(['support_livestream' => true])],
                ['name' => 'Server 6', 'code' => 'IC_S6', 'price_per_unit' => 432, 'status' => 'active', 'description' => 'Việt Nam. Tốc độ ổn', 'min_quantity' => 10, 'max_quantity' => 500],
                ['name' => 'Server 7', 'code' => 'IC_S7', 'price_per_unit' => 600, 'status' => 'active', 'description' => 'Việt Nam. Tốc độ trung bình', 'min_quantity' => 10, 'max_quantity' => 500],
                ['name' => 'Server 8', 'code' => 'IC_S8', 'price_per_unit' => 9000, 'status' => 'active', 'description' => 'Nick tích xanh Tên Việt Nam', 'min_quantity' => 10, 'max_quantity' => 500],
                ['name' => 'Server 9', 'code' => 'IC_S9', 'price_per_unit' => 288, 'status' => 'active', 'description' => 'Bình luận ẩn. (dư bình luận cao)', 'min_quantity' => 10, 'max_quantity' => 500],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $increaseComment->id,
                ]));
            }
        }

        // Chia sẻ bài viết
        $sharePost = Service::where('slug', 'share-post')->first();
        if ($sharePost) {
            $servers = [
                ['name' => 'Server 2', 'code' => 'SP_S2', 'price_per_unit' => 276, 'status' => 'active', 'description' => 'Chia sẻ việt, tốc độ nhanh', 'min_quantity' => 20, 'max_quantity' => 10000],
                ['name' => 'Server 6', 'code' => 'SP_S6', 'price_per_unit' => 348, 'status' => 'active', 'description' => 'Share việt, tốc độ siêu tốc', 'min_quantity' => 20, 'max_quantity' => 10000],
                ['name' => 'Server 7', 'code' => 'SP_S7', 'price_per_unit' => 360, 'status' => 'active', 'description' => 'Kèm nội dung khi share', 'min_quantity' => 20, 'max_quantity' => 10000],
                ['name' => 'Server 5', 'code' => 'SP_S5', 'price_per_unit' => 24, 'status' => 'active', 'description' => 'Share ảo [Lên Siêu Tốc - hỗ trợ tất cả link fb]', 'min_quantity' => 1],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $sharePost->id,
                ]));
            }
        }

        // Tăng Member Group
        $memberGroup = Service::where('slug', 'member-group')->first();
        if ($memberGroup) {
            $servers = [
                ['name' => 'Server 3', 'code' => 'MG_S3', 'price_per_unit' => 42.7, 'status' => 'active', 'description' => 'Member beta, Tên Việt Nam [30k / 24 giờ.]', 'min_quantity' => 1000, 'max_quantity' => 30000],
                ['name' => 'Server 4', 'code' => 'MG_S4', 'price_per_unit' => 14.4, 'status' => 'stopped', 'description' => 'Fb Via tên Việt Nam [5k-10k/ 24 giờ.]', 'min_quantity' => 1000, 'max_quantity' => 30000],
                ['name' => 'Server 5', 'code' => 'MG_S5', 'price_per_unit' => 41.4, 'status' => 'active', 'description' => 'Fb Via tên Việt Nam [10k/ 24 giờ.]', 'min_quantity' => 1000, 'max_quantity' => 30000],
                ['name' => 'Server 6', 'code' => 'MG_S6', 'price_per_unit' => 15.6, 'status' => 'active', 'description' => 'Member Beta ngoại [20k / 24 giờ]', 'min_quantity' => 1000, 'max_quantity' => 30000],
                ['name' => 'Server 15', 'code' => 'MG_S15', 'price_per_unit' => 62.2, 'status' => 'active', 'description' => 'Fb Via tên Việt Nam [5k-10k / 24 giờ.]', 'min_quantity' => 1000, 'max_quantity' => 30000],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $memberGroup->id,
                ]));
            }
        }

        // Đánh giá 5* Fanpage
        $reviewFanpage = Service::where('slug', 'review-fanpage')->first();
        if ($reviewFanpage) {
            $servers = [
                ['name' => 'Server 5', 'code' => 'RV_S5', 'price_per_unit' => 1380, 'status' => 'active', 'description' => 'Via việt. Chất lượng tốt (yêu cầu tối thiểu 1 đánh giá)', 'min_quantity' => 1],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $reviewFanpage->id,
                ]));
            }
        }

        // Check-in Fanpage
        $checkinFanpage = Service::where('slug', 'checkin-fanpage')->first();
        if ($checkinFanpage) {
            $servers = [
                ['name' => 'Server 2', 'code' => 'CI_S2', 'price_per_unit' => 576, 'status' => 'stopped', 'description' => 'Lên nhanh - Bảo hành 30 ngày (Bảo trì)', 'min_quantity' => 1],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $checkinFanpage->id,
                ]));
            }
        }

        // Sự kiện Facebook
        $eventFacebook = Service::where('slug', 'event-facebook')->first();
        if ($eventFacebook) {
            $servers = [
                ['name' => 'Quan tâm event', 'code' => 'EV_QT', 'price_per_unit' => 384, 'status' => 'stopped', 'description' => 'Quan tâm event - người tham gia nước ngoài (Bảo trì)', 'min_quantity' => 100, 'max_quantity' => 50000],
                ['name' => 'Tham gia event', 'code' => 'EV_TG', 'price_per_unit' => 384, 'status' => 'stopped', 'description' => 'Tham gia event - người tham gia nước ngoài (Bảo trì)', 'min_quantity' => 100, 'max_quantity' => 50000],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $eventFacebook->id,
                ]));
            }
        }

        // VIP Like theo tháng
        $vipLikeMonthly = Service::where('slug', 'vip-like-monthly')->first();
        if ($vipLikeMonthly) {
            $servers = [
                ['name' => 'Server 9', 'code' => 'VIPL_S9', 'price_per_unit' => 1260, 'status' => 'active', 'description' => 'Like Việt. 1,260 ₫. Thời gian 7h-23h, giới hạn 5 bài/ngày. Lên sau 5-30p'],
                ['name' => 'Server 10', 'code' => 'VIPL_S10', 'price_per_unit' => 2520, 'status' => 'active', 'description' => 'Like Việt tốt nhất. 2,520 ₫'],
                ['name' => 'Server 11', 'code' => 'VIPL_S11', 'price_per_unit' => 1764, 'status' => 'active', 'description' => 'Like Việt 1,764 ₫'],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $vipLikeMonthly->id,
                    'min_quantity' => 1,
                ]));
            }
        }

        // VIP Like group theo tháng
        $vipLikeGroupMonthly = Service::where('slug', 'vip-like-group-monthly')->first();
        if ($vipLikeGroupMonthly) {
            $servers = [
                ['name' => 'Server 1', 'code' => 'VIPLG_S1', 'price_per_unit' => 1308, 'status' => 'stopped', 'description' => 'Like Via Việt - tốc độ chậm. 1,308 ₫'],
                ['name' => 'Server 2', 'code' => 'VIPLG_S2', 'price_per_unit' => 2340, 'status' => 'stopped', 'description' => 'Like Via Việt - tốc độ tốt. 2,340 ₫'],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $vipLikeGroupMonthly->id,
                    'min_quantity' => 1,
                ]));
            }
        }

        // VIP Comment theo tháng
        $vipCommentMonthly = Service::where('slug', 'vip-comment-monthly')->first();
        if ($vipCommentMonthly) {
            $servers = [
                ['name' => 'Server 5', 'code' => 'VIPC_S5', 'price_per_unit' => 24000, 'status' => 'active', 'description' => 'Việt Nam. Tốc độ nhanh. Min/Max: 10/100. Tối đa 100 cmt/lần mua. Không nội dung vi phạm.'],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $vipCommentMonthly->id,
                    'min_quantity' => 10,
                    'max_quantity' => 100,
                ]));
            }
        }

        // VIP Mắt theo tháng
        $vipEyeMonthly = Service::where('slug', 'vip-eye-monthly')->first();
        if ($vipEyeMonthly) {
            $servers = [
                ['name' => 'Server 2 (Theo bài)', 'code' => 'VIPEYE_S2', 'price_per_unit' => 3.1, 'status' => 'active', 'description' => 'Mắt theo bài, số lượng 50-5000, nhập thời gian/phút/bài', 'min_quantity' => 50, 'max_quantity' => 5000],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $vipEyeMonthly->id,
                ]));
            }
        }

        // VIP View theo tháng
        $vipViewMonthly = Service::where('slug', 'vip-view-monthly')->first();
        if ($vipViewMonthly) {
            $servers = [
                ['name' => 'Server 1', 'code' => 'VIPV_S1', 'price_per_unit' => 14.4, 'status' => 'stopped', 'description' => 'View video, xem 3s, tối đa 6 video/ngày, tốc độ tùy chọn', 'min_quantity' => 1],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $vipViewMonthly->id,
                ]));
            }
        }

        // VIP Share theo tháng
        $vipShareMonthly = Service::where('slug', 'vip-share-monthly')->first();
        if ($vipShareMonthly) {
            $servers = [
                ['name' => 'Server 2', 'code' => 'VIPS_S2', 'price_per_unit' => 13200, 'status' => 'active', 'description' => 'Share Việt. Không hoàn tiền kể cả uid die. Số bài/ngày tùy chọn, gói VIP tùy chọn.', 'min_quantity' => 1],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $vipShareMonthly->id,
                ]));
            }
        }
    }
}

