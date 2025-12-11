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

        // Buff mắt Livestream V2
        $buffEyeLive = Service::where('slug', 'buff-mat-livestream-v2')->first();
        if ($buffEyeLive) {
            $servers = [
                [
                    'name' => 'Server 4',
                    'code' => 'LIVEV2_S4',
                    'price_per_unit' => 79.2,
                    'status' => 'active',
                    'description' => 'Máy chủ 518398 - Mắt xem livestream Facebook v4 ~30 phút',
                    'min_quantity' => 50,
                    'max_quantity' => 1000,
                    'features' => json_encode([
                        'required_link_contains' => 'Videos',
                        'duration_minutes' => 30,
                    ]),
                ],
                [
                    'name' => 'Server 6',
                    'code' => 'LIVEV2_S6',
                    'price_per_unit' => 79.2,
                    'status' => 'active',
                    'description' => 'Máy chủ 518398 - Mắt xem livestream Facebook v4 ~30 phút',
                    'min_quantity' => 50,
                    'max_quantity' => 1000,
                    'features' => json_encode([
                        'required_link_contains' => 'Videos',
                        'duration_minutes' => 30,
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $buffEyeLive->id,
                ]));
            }
        }

        // Tăng View video
        $increaseViewVideo = Service::where('slug', 'tang-view-video')->first();
        if ($increaseViewVideo) {
            $servers = [
                [
                    'name' => 'Server 4',
                    'code' => 'VIEW_S4',
                    'price_per_unit' => 10.2,
                    'status' => 'active',
                    'description' => 'Gói view giá tốt, auto phát (play) nếu video bị ẩn view',
                    'min_quantity' => 500,
                    'max_quantity' => 5000000,
                    'features' => json_encode([
                        'fallback_play_on_hidden_view' => true,
                        'note' => 'Video <1 phút sẽ lên chậm, đơn lớn tăng tốc độ tốt hơn',
                    ]),
                ],
                [
                    'name' => 'Server 7',
                    'code' => 'VIEW_S7',
                    'price_per_unit' => 13.2,
                    'status' => 'active',
                    'description' => 'Tốc độ lên ổn định, ưu tiên đơn số lượng lớn',
                    'min_quantity' => 500,
                    'max_quantity' => 5000000,
                    'features' => json_encode([
                        'fallback_play_on_hidden_view' => true,
                        'note' => 'Video <1 phút sẽ lên chậm, đơn lớn tăng tốc độ tốt hơn',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $increaseViewVideo->id,
                ]));
            }
        }

        // Tăng View Story
        $increaseViewStory = Service::where('slug', 'tang-view-story')->first();
        if ($increaseViewStory) {
            $servers = [
                [
                    'name' => 'Server 2',
                    'code' => 'STORY_S2',
                    'price_per_unit' => 24,
                    'status' => 'active',
                    'description' => 'Tốc độ ổn, không mua trùng khi view chưa đủ, nên mua ngay sau khi đăng',
                    'min_quantity' => 200,
                    'max_quantity' => 20000,
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'STORY_S3',
                    'price_per_unit' => 57.4,
                    'status' => 'active',
                    'description' => 'Tốc độ tốt, lưu ý thời gian story',
                    'min_quantity' => 200,
                    'max_quantity' => 20000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $increaseViewStory->id,
                ]));
            }
        }

        // View 600k phút
        $view600kMinutes = Service::where('slug', 'view-600k-phut')->first();
        if ($view600kMinutes) {
            $servers = [
                [
                    'name' => 'Gói 600k phút',
                    'code' => 'VIEW600K',
                    'price_per_unit' => 300000,
                    'status' => 'active',
                    'description' => 'Hoàn thành trong 1-2 ngày, video tối thiểu 60 phút',
                    'min_quantity' => 1,
                    'max_quantity' => 1,
                    'features' => json_encode([
                        'package_minutes' => 600000,
                        'min_video_length_minutes' => 60,
                        'completion' => '1-2 ngày',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $view600kMinutes->id,
                ]));
            }
        }

        // View 60K offline
        $view60kOffline = Service::where('slug', 'view-60k-offline')->first();
        if ($view60kOffline) {
            $servers = [
                [
                    'name' => 'Server 1 (VIP)',
                    'code' => 'OFF60K_S1',
                    'price_per_unit' => 114000,
                    'status' => 'active',
                    'description' => 'Ưu tiên lên nhanh, hoàn thành trong ngày',
                    'min_quantity' => 1,
                    'max_quantity' => 1,
                    'features' => json_encode([
                        'available_orders' => 1850,
                        'video_length_hours' => 3,
                        'extra_seconds_required' => 3,
                        'completion' => 'Trong ngày',
                        'package_minutes' => 60000,
                    ]),
                ],
                [
                    'name' => 'Server 2 (Thường)',
                    'code' => 'OFF60K_S2',
                    'price_per_unit' => 87600,
                    'status' => 'active',
                    'description' => 'Gói thường, tốc độ ổn định',
                    'min_quantity' => 1,
                    'max_quantity' => 1,
                    'features' => json_encode([
                        'available_orders' => 1851,
                        'video_length_hours' => 3,
                        'extra_seconds_required' => 3,
                        'package_minutes' => 60000,
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $view60kOffline->id,
                ]));
            }
        }

        // View 60K Live
        $view60kLive = Service::where('slug', 'view-60k-live')->first();
        if ($view60kLive) {
            $servers = [
                [
                    'name' => 'Server 1 (VIP)',
                    'code' => 'LIVE60K_S1',
                    'price_per_unit' => 228000,
                    'status' => 'active',
                    'description' => 'Ưu tiên lên nhanh, hoàn thành trong ngày cho live',
                    'min_quantity' => 1,
                    'max_quantity' => 1,
                    'features' => json_encode([
                        'available_orders' => 1817,
                        'video_length_hours' => 3,
                        'extra_seconds_required' => 3,
                        'package_minutes' => 60000,
                    ]),
                ],
                [
                    'name' => 'Server 2 (Thường)',
                    'code' => 'LIVE60K_S2',
                    'price_per_unit' => 138000,
                    'status' => 'active',
                    'description' => 'Gói thường cho live, tốc độ ổn',
                    'min_quantity' => 1,
                    'max_quantity' => 1,
                    'features' => json_encode([
                        'available_orders' => 1897,
                        'video_length_hours' => 3,
                        'extra_seconds_required' => 3,
                        'package_minutes' => 60000,
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $view60kLive->id,
                ]));
            }
        }

        // Tăng view 100k Reels
        $viewReels = Service::where('slug', 'tang-view-100k-reels')->first();
        if ($viewReels) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'REELS_S1',
                    'price_per_unit' => 600000,
                    'status' => 'active',
                    'description' => 'Lên nhanh 100k Reels, nhập đúng link/uid',
                    'min_quantity' => 1,
                    'max_quantity' => 1,
                    'features' => json_encode([
                        'available_orders' => 0,
                        'note' => 'Khả dụng 0 đơn - liên hệ trước khi đặt',
                    ]),
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'REELS_S2',
                    'price_per_unit' => 312000,
                    'status' => 'active',
                    'description' => 'Lên trung bình 100k Reels',
                    'min_quantity' => 1,
                    'max_quantity' => 1,
                    'features' => json_encode([
                        'available_orders' => 0,
                        'note' => 'Khả dụng 0 đơn - liên hệ trước khi đặt',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $viewReels->id,
                ]));
            }
        }

        // Lọc bạn bè không tương tác
        $friendCleanup = Service::where('slug', 'loc-ban-be-khong-tuong-tac')->first();
        if ($friendCleanup) {
            $servers = [
                [
                    'name' => 'Lọc bạn bè không tương tác',
                    'code' => 'FRIEND_CLEAN',
                    'price_per_unit' => 15000,
                    'status' => 'active',
                    'description' => 'Nhập ID/link Facebook và tên tài khoản cần lọc bạn bè không tương tác',
                    'min_quantity' => 1,
                    'max_quantity' => 1,
                    'features' => json_encode([
                        'requires_username' => true,
                        'note' => 'Tài khoản cần chạy VIP',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $friendCleanup->id,
                ]));
            }
        }

        // Like Instagram
        $likeInstagram = Service::where('slug', 'like-instagram')->first();
        if ($likeInstagram) {
            $servers = [
                [
                    'name' => 'Server 1 (Like Việt)',
                    'code' => 'IGLIKE_S1',
                    'price_per_unit' => 27.6,
                    'status' => 'active',
                    'description' => 'Like Việt, 500/24h (tụt 10-20%)',
                    'min_quantity' => 100,
                    'max_quantity' => 50000,
                ],
                [
                    'name' => 'Server 2 (Like Việt)',
                    'code' => 'IGLIKE_S2',
                    'price_per_unit' => 25.2,
                    'status' => 'active',
                    'description' => 'Like Việt, 5k-10k/24h',
                    'min_quantity' => 100,
                    'max_quantity' => 50000,
                ],
                [
                    'name' => 'Server 4 (Like Việt)',
                    'code' => 'IGLIKE_S4',
                    'price_per_unit' => 13.6,
                    'status' => 'active',
                    'description' => 'Like Việt, tốc độ trung bình',
                    'min_quantity' => 100,
                    'max_quantity' => 50000,
                ],
                [
                    'name' => 'Server 5 (Like Tây)',
                    'code' => 'IGLIKE_S5',
                    'price_per_unit' => 8.6,
                    'status' => 'active',
                    'description' => 'Like Tây, tốc độ trung bình, không bảo hành',
                    'min_quantity' => 100,
                    'max_quantity' => 50000,
                ],
                [
                    'name' => 'Server 6 (Like Tây)',
                    'code' => 'IGLIKE_S6',
                    'price_per_unit' => 14.8,
                    'status' => 'active',
                    'description' => 'Like Tây, tốc độ tốt, không bảo hành',
                    'min_quantity' => 100,
                    'max_quantity' => 50000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $likeInstagram->id,
                ]));
            }
        }

        // Comment Instagram
        $commentInstagram = Service::where('slug', 'comment-instagram')->first();
        if ($commentInstagram) {
            $servers = [
                [
                    'name' => 'Server 2 (Nick Việt)',
                    'code' => 'IGCMT_S2',
                    'price_per_unit' => 720,
                    'status' => 'active',
                    'description' => 'Comment Instagram nick Việt, tốc độ trung bình',
                    'min_quantity' => 10,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'speed_options' => ['nhanh', 'trung_binh', 'cham'],
                        'note' => 'ID: 475481',
                    ]),
                ],
                [
                    'name' => 'Server 3 (Nick Ngoại)',
                    'code' => 'IGCMT_S3',
                    'price_per_unit' => 192,
                    'status' => 'active',
                    'description' => 'Comment Instagram nick ngoại',
                    'min_quantity' => 10,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'speed_options' => ['nhanh', 'trung_binh', 'cham'],
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $commentInstagram->id,
                ]));
            }
        }

        // Follow Instagram
        $followInstagram = Service::where('slug', 'follow-instagram')->first();
        if ($followInstagram) {
            $servers = [
                [
                    'name' => 'Server 1 (Sub Việt)',
                    'code' => 'IGFOLLOW_S1',
                    'price_per_unit' => 94.8,
                    'status' => 'stopped',
                    'description' => 'Sub Việt 500/24h, tụt cao, bảo hành 7 ngày',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'warranty_days' => 7,
                        'note' => 'Trạng thái bảo trì',
                        'speed_per_day' => 500,
                        'drop_rate' => 'cao',
                        'over_provision_percent' => 15,
                    ]),
                ],
                [
                    'name' => 'Server 6 (Sub Tây)',
                    'code' => 'IGFOLLOW_S6',
                    'price_per_unit' => 26.4,
                    'status' => 'active',
                    'description' => 'Tốc độ 20k/24h, không bảo hành',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'speed_per_day' => 20000,
                        'warranty_days' => 0,
                        'over_provision_percent' => 15,
                    ]),
                ],
                [
                    'name' => 'Server 7 (Sub Tây)',
                    'code' => 'IGFOLLOW_S7',
                    'price_per_unit' => 53.8,
                    'status' => 'active',
                    'description' => 'Tốc độ 2k/24h, không bảo hành',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'speed_per_day' => 2000,
                        'warranty_days' => 0,
                        'over_provision_percent' => 15,
                    ]),
                ],
                [
                    'name' => 'Server 8 (Sub Tây)',
                    'code' => 'IGFOLLOW_S8',
                    'price_per_unit' => 106.8,
                    'status' => 'active',
                    'description' => 'Tốc độ 5k/24h, không bảo hành',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'speed_per_day' => 5000,
                        'warranty_days' => 0,
                        'over_provision_percent' => 15,
                    ]),
                ],
                [
                    'name' => 'Server 9 (Sub Tây)',
                    'code' => 'IGFOLLOW_S9',
                    'price_per_unit' => 83.4,
                    'status' => 'active',
                    'description' => 'Tốc độ 10k/24h, không bảo hành',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'speed_per_day' => 10000,
                        'warranty_days' => 0,
                        'over_provision_percent' => 15,
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $followInstagram->id,
                ]));
            }
        }

        // View Instagram
        $viewInstagram = Service::where('slug', 'view-instagram')->first();
        if ($viewInstagram) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'IGVIEW_S1',
                    'price_per_unit' => 10.6,
                    'status' => 'active',
                    'description' => 'View Video+REEL+IGTV, tốc độ có thể đạt triệu view/ngày (ID: 475417)',
                    'min_quantity' => 100,
                    'max_quantity' => 1000000,
                    'features' => json_encode([
                        'note' => 'Tốc độ có thể thay đổi',
                        'supported' => 'Video/REEL/IGTV',
                    ]),
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'IGVIEW_S2',
                    'price_per_unit' => 0.48,
                    'status' => 'active',
                    'description' => 'View Video+REEL+IGTV, min 10k',
                    'min_quantity' => 10000,
                    'max_quantity' => 1000000,
                    'features' => json_encode([
                        'supported' => 'Video/REEL/IGTV',
                    ]),
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'IGVIEW_S3',
                    'price_per_unit' => 2.2,
                    'status' => 'active',
                    'description' => 'View Video+REEL+IGTV, 8đ',
                    'min_quantity' => 100,
                    'max_quantity' => 1000000,
                    'features' => json_encode([
                        'supported' => 'Video/REEL/IGTV',
                    ]),
                ],
                [
                    'name' => 'Server 5 (Story)',
                    'code' => 'IGVIEW_S5',
                    'price_per_unit' => 4.2,
                    'status' => 'active',
                    'description' => 'Chỉ hỗ trợ stories 24 giờ',
                    'min_quantity' => 100,
                    'max_quantity' => 1000000,
                    'features' => json_encode([
                        'supported' => 'Story',
                        'story_duration_hours' => 24,
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $viewInstagram->id,
                ]));
            }
        }

        // Mắt LiveStream Instagram
        $liveEyeInstagram = Service::where('slug', 'mat-livestream-instagram')->first();
        if ($liveEyeInstagram) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'IGLIVE_S1',
                    'price_per_unit' => 18.2,
                    'status' => 'active',
                    'description' => 'Mắt LiveStream 15đ, tốc độ có thể đạt triệu view/ngày',
                    'min_quantity' => 100,
                    'max_quantity' => 1000000,
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'IGLIVE_S2',
                    'price_per_unit' => 0.84,
                    'status' => 'active',
                    'description' => 'Mắt LiveStream min 10k',
                    'min_quantity' => 10000,
                    'max_quantity' => 1000000,
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'IGLIVE_S3',
                    'price_per_unit' => 4.4,
                    'status' => 'active',
                    'description' => 'Mắt LiveStream 12đ',
                    'min_quantity' => 100,
                    'max_quantity' => 1000000,
                ],
                [
                    'name' => 'Server 5 (Story)',
                    'code' => 'IGLIVE_S5',
                    'price_per_unit' => 8.4,
                    'status' => 'active',
                    'description' => 'Chỉ hỗ trợ stories 24 giờ',
                    'min_quantity' => 100,
                    'max_quantity' => 1000000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $liveEyeInstagram->id,
                ]));
            }
        }

        // VIP Like Instagram
        $vipLikeInstagram = Service::where('slug', 'vip-like-instagram')->first();
        if ($vipLikeInstagram) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'IGVIPLIKE_S1',
                    'price_per_unit' => 900,
                    'status' => 'active',
                    'description' => 'Like Việt, không nên ghim bài',
                    'min_quantity' => 1,
                    'features' => json_encode([
                        'note' => 'Chọn thời gian 1/2/3 tháng, tùy chọn số bài mỗi ngày',
                        'avoid_pin' => true,
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $vipLikeInstagram->id,
                ]));
            }
        }

        // VIP Comment Instagram
        $vipCommentInstagram = Service::where('slug', 'vip-comment-instagram')->first();
        if ($vipCommentInstagram) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'IGVIPCMT_S1',
                    'price_per_unit' => 16680,
                    'status' => 'active',
                    'description' => 'Bắt buộc không ghim bài, chọn gói 10-100 bình luận, tốc độ và thời gian tùy chọn',
                    'min_quantity' => 1,
                    'features' => json_encode([
                        'packages' => [10,20,30,40,50,60,70,80,90,100],
                        'avoid_pin' => true,
                        'duration_options' => ['1 tháng','2 tháng','3 tháng'],
                        'speed_options' => ['nhanh','trung_binh','cham'],
                        'per_day_posts' => 'tùy chọn',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $vipCommentInstagram->id,
                ]));
            }
        }

        // Like Threads
        $likeThreads = Service::where('slug', 'like-threads')->first();
        if ($likeThreads) {
            $servers = [
                [
                    'name' => 'Server 2',
                    'code' => 'THREADS_LIKE_S2',
                    'price_per_unit' => 64.8,
                    'status' => 'stopped',
                    'description' => 'Like tây. ổn định. Lên khá nhanh',
                    'min_quantity' => 50,
                    'max_quantity' => 500000,
                    'features' => json_encode([
                        'id' => '475517',
                        'note' => 'Ngừng nhận đơn',
                    ]),
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'THREADS_LIKE_S3',
                    'price_per_unit' => 42,
                    'status' => 'stopped',
                    'description' => 'Like việt. Giá rẻ - Bảo trì',
                    'min_quantity' => 1,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $likeThreads->id,
                ]));
            }
        }

        // Follow Threads
        $followThreads = Service::where('slug', 'follow-threads')->first();
        if ($followThreads) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'THREADS_FOLLOW_S1',
                    'price_per_unit' => 75.6,
                    'status' => 'stopped',
                    'description' => 'Sub ngoại, Không bảo hành. Tốc độ lên nhanh. Tỉ lệ tụt thấp',
                    'min_quantity' => 100,
                    'max_quantity' => 100000,
                    'features' => json_encode([
                        'id' => '475505',
                        'note' => 'Ngừng nhận đơn',
                    ]),
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'THREADS_FOLLOW_S2',
                    'price_per_unit' => 40.8,
                    'status' => 'stopped',
                    'description' => 'Sub ngoại, Không bảo hành - Bảo trì',
                    'min_quantity' => 1,
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'THREADS_FOLLOW_S3',
                    'price_per_unit' => 54,
                    'status' => 'active',
                    'description' => 'Sub tên Việt, 100-500 /24 giờ',
                    'min_quantity' => 1,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $followThreads->id,
                ]));
            }
        }

        // Like TikTok
        $likeTiktok = Service::where('slug', 'tiktok-like')->first();
        if ($likeTiktok) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'TIKLIKE_S1',
                    'price_per_unit' => 14.4,
                    'status' => 'active',
                    'description' => 'Like việt, 5k/24h, hoàn tiền khi chậm, phù hợp gói nhỏ <1k, tốc độ rất nhanh, tụt cao',
                    'min_quantity' => 50,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'id' => '475278',
                        'note' => 'Like việt, hỗ trợ hoàn tiền khi chậm, có thể tụt cao theo thời gian',
                    ]),
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'TIKLIKE_S3',
                    'price_per_unit' => 15.0,
                    'status' => 'active',
                    'description' => 'Like việt, 5k/24h',
                    'min_quantity' => 50,
                    'max_quantity' => 10000,
                ],
                [
                    'name' => 'Server 5',
                    'code' => 'TIKLIKE_S5',
                    'price_per_unit' => 16.2,
                    'status' => 'active',
                    'description' => 'Like việt, 5k/24 giờ',
                    'min_quantity' => 50,
                    'max_quantity' => 10000,
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'TIKLIKE_S2',
                    'price_per_unit' => 5.8,
                    'status' => 'active',
                    'description' => 'Like ngoại, giá rẻ nhất',
                    'min_quantity' => 50,
                    'max_quantity' => 10000,
                ],
                [
                    'name' => 'Server 6',
                    'code' => 'TIKLIKE_S6',
                    'price_per_unit' => 11.4,
                    'status' => 'active',
                    'description' => 'Like ngoại, tốc độ tốt',
                    'min_quantity' => 50,
                    'max_quantity' => 10000,
                ],
                [
                    'name' => 'Server 7',
                    'code' => 'TIKLIKE_S7',
                    'price_per_unit' => 10.1,
                    'status' => 'active',
                    'description' => 'Like ngoại',
                    'min_quantity' => 50,
                    'max_quantity' => 10000,
                ],
                [
                    'name' => 'Server 8',
                    'code' => 'TIKLIKE_S8',
                    'price_per_unit' => 16.2,
                    'status' => 'active',
                    'description' => 'Like ngoại, rất nhanh',
                    'min_quantity' => 50,
                    'max_quantity' => 10000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $likeTiktok->id,
                ]));
            }
        }

        // Like Comment TikTok
        $likeCommentTiktok = Service::where('slug', 'tiktok-like-comment')->first();
        if ($likeCommentTiktok) {
            $servers = [
                [
                    'name' => 'Server 2',
                    'code' => 'TIKLC_S2',
                    'price_per_unit' => 20.4,
                    'status' => 'active',
                    'description' => 'Tốc độ nhanh. User nhiều dấu chấm có thể không nhận diện được và hoàn.',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'id' => '475571',
                        'note' => 'Dùng link/username profile bình luận. Username nhiều dấu chấm có thể không nhận diện.',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $likeCommentTiktok->id,
                ]));
            }
        }

        // Follow TikTok
        $followTiktok = Service::where('slug', 'tiktok-follow')->first();
        if ($followTiktok) {
            $servers = [
                [
                    'name' => 'Server 2',
                    'code' => 'TIKFOLLOW_S2',
                    'price_per_unit' => 94.8,
                    'status' => 'active',
                    'description' => 'Sub việt 5k/24h, bảo hành 7 ngày, không hỗ trợ đổi username, có thể tụt gốc',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'id' => '475590',
                        'warranty_days' => 7,
                        'speed_per_day' => 5000,
                        'note' => 'Không hỗ trợ khi đổi username; có thể tụt gốc',
                    ]),
                ],
                [
                    'name' => 'Server 4',
                    'code' => 'TIKFOLLOW_S4',
                    'price_per_unit' => 73.2,
                    'status' => 'slow',
                    'description' => 'Sub việt 300/24h',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                ],
                [
                    'name' => 'Server 5',
                    'code' => 'TIKFOLLOW_S5',
                    'price_per_unit' => 28.2,
                    'status' => 'active',
                    'description' => 'Sub việt 3k/24h, có hiện tượng tụt cao',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                ],
                [
                    'name' => 'Server 6',
                    'code' => 'TIKFOLLOW_S6',
                    'price_per_unit' => 40.8,
                    'status' => 'active',
                    'description' => 'Sub việt 1k/1 ngày, có hiện tượng tụt cao',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'TIKFOLLOW_S3',
                    'price_per_unit' => 45.4,
                    'status' => 'active',
                    'description' => 'Sub ngoại 5k-10k/24h',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                ],
                [
                    'name' => 'Server 7',
                    'code' => 'TIKFOLLOW_S7',
                    'price_per_unit' => 66.0,
                    'status' => 'active',
                    'description' => 'Sub ngoại 5k/24h',
                    'min_quantity' => 100,
                    'max_quantity' => 10000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $followTiktok->id,
                ]));
            }
        }

        // View TikTok
        $viewTiktok = Service::where('slug', 'tiktok-view')->first();
        if ($viewTiktok) {
            $servers = [
                [
                    'name' => 'Server 3',
                    'code' => 'TIKVIEW_S3',
                    'price_per_unit' => 0.84,
                    'status' => 'active',
                    'description' => 'Ổn định. Nên hẹn giờ 10k/đơn cách 12-24h khi mua số lượng cao để hạn chế tụt.',
                    'min_quantity' => 1000,
                    'max_quantity' => 100000,
                    'features' => json_encode([
                        'id' => '475384',
                        'note' => 'Mua số cao có rủi ro tụt hết sau 1-3 ngày',
                    ]),
                ],
                [
                    'name' => 'Server 4',
                    'code' => 'TIKVIEW_S4',
                    'price_per_unit' => 0.84,
                    'status' => 'active',
                    'description' => 'Ổn định',
                    'min_quantity' => 1000,
                    'max_quantity' => 100000,
                ],
                [
                    'name' => 'Server 5',
                    'code' => 'TIKVIEW_S5',
                    'price_per_unit' => 1.1,
                    'status' => 'active',
                    'description' => 'Tăng chậm, hạn chế tụt',
                    'min_quantity' => 1000,
                    'max_quantity' => 100000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $viewTiktok->id,
                ]));
            }
        }

        // Comment TikTok
        $commentTiktok = Service::where('slug', 'tiktok-comment')->first();
        if ($commentTiktok) {
            $servers = [
                [
                    'name' => 'Server 4',
                    'code' => 'TIKCMT_S4',
                    'price_per_unit' => 720,
                    'status' => 'slow',
                    'description' => 'Nick việt, tốc độ chậm, cần tối thiểu 1 bình luận',
                    'min_quantity' => 10,
                    'max_quantity' => 20,
                    'features' => json_encode([
                        'id' => '475477',
                        'note' => 'Nội dung có thể bị ẩn/trùng; tắt lọc/kiểm duyệt nội dung',
                    ]),
                ],
                [
                    'name' => 'Server 6',
                    'code' => 'TIKCMT_S6',
                    'price_per_unit' => 408,
                    'status' => 'stopped',
                    'description' => 'Nick ngoại, tốc độ nhanh',
                    'min_quantity' => 10,
                    'max_quantity' => 20,
                    'features' => json_encode([
                        'note' => 'Bảo trì',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $commentTiktok->id,
                ]));
            }
        }

        // Share TikTok
        $shareTiktok = Service::where('slug', 'tiktok-share')->first();
        if ($shareTiktok) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'TIKSHARE_S1',
                    'price_per_unit' => 16.6,
                    'status' => 'stopped',
                    'description' => 'Bảo hành 30 ngày',
                    'min_quantity' => 100,
                    'max_quantity' => 50000000,
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'TIKSHARE_S2',
                    'price_per_unit' => 7.0,
                    'status' => 'active',
                    'description' => 'Ổn định, BH 30 ngày. Nếu delay có thể chậm, không lỗi thì lên siêu tốc, share thường lên dư',
                    'min_quantity' => 100,
                    'max_quantity' => 50000000,
                    'features' => json_encode([
                        'id' => '475414',
                        'note' => 'Share có thể lên dư',
                    ]),
                ],
                [
                    'name' => 'Server 4',
                    'code' => 'TIKSHARE_S4',
                    'price_per_unit' => 3.1,
                    'status' => 'stopped',
                    'description' => 'Giá rẻ nhất',
                    'min_quantity' => 100,
                    'max_quantity' => 50000000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $shareTiktok->id,
                ]));
            }
        }

        // Save TikTok (Yêu thích)
        $saveTiktok = Service::where('slug', 'tiktok-save')->first();
        if ($saveTiktok) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'TIKSAVE_S1',
                    'price_per_unit' => 8.2,
                    'status' => 'active',
                    'description' => 'Tốc độ tốt, có thể rất nhanh',
                    'min_quantity' => 100,
                    'max_quantity' => 1000000,
                    'features' => json_encode([
                        'id' => '475424',
                    ]),
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'TIKSAVE_S2',
                    'price_per_unit' => 9.6,
                    'status' => 'active',
                    'description' => 'Tốc độ trung bình',
                    'min_quantity' => 100,
                    'max_quantity' => 1000000,
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'TIKSAVE_S3',
                    'price_per_unit' => 14.4,
                    'status' => 'stopped',
                    'description' => 'Ổn định, lên chậm',
                    'min_quantity' => 100,
                    'max_quantity' => 1000000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $saveTiktok->id,
                ]));
            }
        }

        // Tim Livestream TikTok
        $liveLikeTiktok = Service::where('slug', 'tiktok-live-like')->first();
        if ($liveLikeTiktok) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'TIKLIVE_LIKE_S1',
                    'price_per_unit' => 10.6,
                    'status' => 'active',
                    'description' => 'Tim livestream TikTok, tốc độ tốt',
                    'min_quantity' => 500,
                    'max_quantity' => 50000,
                    'features' => json_encode([
                        'id' => '475428',
                    ]),
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'TIKLIVE_LIKE_S3',
                    'price_per_unit' => 6.0,
                    'status' => 'stopped',
                    'description' => 'Tim livestream TikTok, tốc độ ổn - Bảo trì',
                    'min_quantity' => 500,
                    'max_quantity' => 50000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $liveLikeTiktok->id,
                ]));
            }
        }

        // Share Livestream TikTok
        $liveShareTiktok = Service::where('slug', 'tiktok-live-share')->first();
        if ($liveShareTiktok) {
            $servers = [
                [
                    'name' => 'Server 2',
                    'code' => 'TIKLIVE_SHARE_S2',
                    'price_per_unit' => 24.0,
                    'status' => 'stopped',
                    'description' => 'Share việt, cấm dồn đơn, thời gian vài phút, lên đều và chậm',
                    'min_quantity' => 200,
                    'max_quantity' => 100000,
                    'features' => json_encode([
                        'id' => '475429',
                        'note' => 'Ngừng nhận đơn; cấm dồn đơn',
                    ]),
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'TIKLIVE_SHARE_S3',
                    'price_per_unit' => 24.0,
                    'status' => 'stopped',
                    'description' => 'Share siêu tốc - Bảo trì',
                    'min_quantity' => 200,
                    'max_quantity' => 100000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $liveShareTiktok->id,
                ]));
            }
        }

        // Comment Livestream TikTok
        $liveCommentTiktok = Service::where('slug', 'tiktok-live-comment')->first();
        if ($liveCommentTiktok) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'TIKLIVE_CMT_S1',
                    'price_per_unit' => 300,
                    'status' => 'active',
                    'description' => 'Icon biểu tượng ngẫu nhiên, tên nước ngoài, tốc độ rất nhanh',
                    'min_quantity' => 10,
                    'max_quantity' => 100000,
                    'features' => json_encode([
                        'id' => '475465',
                    ]),
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'TIKLIVE_CMT_S2',
                    'price_per_unit' => 468,
                    'status' => 'stopped',
                    'description' => 'Nội dung tự nhập - Bảo trì',
                    'min_quantity' => 10,
                    'max_quantity' => 100000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $liveCommentTiktok->id,
                ]));
            }
        }

        // Mắt Livestream TikTok
        $liveEyeTiktok = Service::where('slug', 'tiktok-live-eye')->first();
        if ($liveEyeTiktok) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'TIKLIVE_EYE_S1',
                    'price_per_unit' => 0,
                    'status' => 'stopped',
                    'description' => 'Mắt livestream TikTok - Bảo trì (chưa cập nhật giá)',
                    'min_quantity' => 1,
                ],
                [
                    'name' => 'Server 5',
                    'code' => 'TIKLIVE_EYE_S5',
                    'price_per_unit' => 0,
                    'status' => 'stopped',
                    'description' => 'Mắt livestream TikTok - Bảo trì (chưa cập nhật giá)',
                    'min_quantity' => 1,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $liveEyeTiktok->id,
                ]));
            }
        }

        // PK Livestream TikTok
        $livePkTiktok = Service::where('slug', 'tiktok-live-pk')->first();
        if ($livePkTiktok) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'TIKLIVE_PK_S1',
                    'price_per_unit' => 16.6,
                    'status' => 'active',
                    'description' => 'Không hoàn khi lỗi; 1 lần live chỉ mua 1 đơn; có thể thiếu; thường tăng kèm lượt like',
                    'min_quantity' => 500,
                    'max_quantity' => 10000,
                    'features' => json_encode([
                        'id' => '475524',
                        'note' => 'Không hoàn khi lỗi, mỗi live 1 đơn',
                    ]),
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'TIKLIVE_PK_S2',
                    'price_per_unit' => 17.8,
                    'status' => 'active',
                    'description' => 'Không hoàn khi lỗi; 1 lần live chỉ mua 1 đơn; có thể thiếu; thường tăng kèm lượt like',
                    'min_quantity' => 500,
                    'max_quantity' => 10000,
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $livePkTiktok->id,
                ]));
            }
        }

        // VIP Love TikTok
        $vipLoveTiktok = Service::where('slug', 'tiktok-vip-like')->first();
        if ($vipLoveTiktok) {
            $servers = [
                [
                    'name' => 'Server 2',
                    'code' => 'TIKVIPLOVE_S2',
                    'price_per_unit' => 504,
                    'status' => 'active',
                    'description' => 'Like việt, bắt đầu chạy tim vài giờ sau khi đăng, gói VIP tháng',
                    'min_quantity' => 1,
                    'features' => json_encode([
                        'id' => '475381',
                        'duration_options' => ['1 tháng','2 tháng','3 tháng'],
                        'posts_per_day' => 'number',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $vipLoveTiktok->id,
                ]));
            }
        }

        // VIP View TikTok
        $vipViewTiktok = Service::where('slug', 'tiktok-vip-view')->first();
        if ($vipViewTiktok) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'TIKVIPVIEW_S1',
                    'price_per_unit' => 20.4,
                    'status' => 'active',
                    'description' => 'VIP view, nhật ký uid lưu bài, view có thể lên chậm tùy thời điểm, có nút bù bài khi huỷ',
                    'min_quantity' => 1,
                    'features' => json_encode([
                        'id' => '475379',
                        'duration_options' => ['1 tháng','2 tháng','3 tháng'],
                        'posts_per_day' => 'number',
                        'note' => 'View có thể chậm do bóp; có nút bù bài nếu bị huỷ',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $vipViewTiktok->id,
                ]));
            }
        }
    }
}

