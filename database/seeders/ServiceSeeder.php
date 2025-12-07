<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'Like bài viết Speed',
                'slug' => 'like-post-speed',
                'category' => 'like_post_speed',
                'description' => 'Like bài viết tốc độ cao',
            ],
            [
                'name' => 'Like bài viết VIP',
                'slug' => 'like-post-vip',
                'category' => 'like_post_vip',
                'description' => 'Like bài viết VIP',
            ],
            [
                'name' => 'Sub cá nhân & Sub fanpage',
                'slug' => 'sub-personal-fanpage',
                'category' => 'sub_personal_fanpage',
                'description' => 'Tăng sub cho cá nhân và fanpage',
            ],
            [
                'name' => 'Like fanpage',
                'slug' => 'like-fanpage',
                'category' => 'like_fanpage',
                'description' => 'Tăng like cho fanpage',
            ],
            [
                'name' => 'Like cho bình luận',
                'slug' => 'like-comment',
                'category' => 'like_comment',
                'description' => 'Like cho bình luận',
            ],
            [
                'name' => 'Tăng bình luận',
                'slug' => 'increase-comment',
                'category' => 'increase_comment',
                'description' => 'Tăng số lượng bình luận',
            ],
            [
                'name' => 'Chia sẻ bài viết',
                'slug' => 'share-post',
                'category' => 'share_post',
                'description' => 'Chia sẻ bài viết',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

