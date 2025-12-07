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
                ['name' => 'Server 3', 'code' => 'SUB_S3', 'price_per_unit' => 41.8, 'status' => 'active', 'description' => 'Sub Tên Việt Nam, tốc độ 2k/1 ngày, bảo hành 7 ngày'],
                ['name' => 'Server 4', 'code' => 'SUB_S4', 'price_per_unit' => 29.6, 'status' => 'slow', 'description' => 'Sub Tên Việt Nam, tốc độ 1k/1 ngày, bảo hành 7 ngày'],
                ['name' => 'Server 6', 'code' => 'SUB_S6', 'price_per_unit' => 36, 'status' => 'active', 'description' => 'Sub Tây, tốc độ 20k/1 ngày, bảo hành 7 ngày'],
                ['name' => 'Server 7', 'code' => 'SUB_S7', 'price_per_unit' => 29.9, 'status' => 'active', 'description' => 'Sub Tây, tốc độ 10k/1 ngày, bảo hành 7 ngày'],
                ['name' => 'Server 8', 'code' => 'SUB_S8', 'price_per_unit' => 16.2, 'status' => 'active', 'description' => 'Sub Tây, tốc độ 30k/1 ngày, bảo hành 7 ngày'],
                ['name' => 'Server 11', 'code' => 'SUB_S11', 'price_per_unit' => 25.8, 'status' => 'stopped', 'description' => 'Sub Việt Nam, tốc độ 5k/1 ngày, bảo hành 7 ngày'],
                ['name' => 'Server 12', 'code' => 'SUB_S12', 'price_per_unit' => 50.4, 'status' => 'stopped', 'description' => 'Sub Việt Nam, tốc độ 10k/1 ngày, bảo hành 7 ngày'],
                ['name' => 'Server 15', 'code' => 'SUB_S15', 'price_per_unit' => 65.8, 'status' => 'stopped', 'description' => 'Sub Việt Nam, tốc độ 30k/1 ngày, bảo hành 7 ngày'],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $subPersonal->id,
                    'min_quantity' => 1,
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
    }
}

