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
            [
                'name' => 'Tăng Member Group',
                'slug' => 'member-group',
                'category' => 'member_group',
                'description' => 'Tăng thành viên nhóm Facebook',
            ],
            [
                'name' => 'Đánh giá 5* Fanpage',
                'slug' => 'review-fanpage',
                'category' => 'review_fanpage',
                'description' => 'Tăng đánh giá 5 sao cho fanpage',
            ],
            [
                'name' => 'Check-in Fanpage',
                'slug' => 'checkin-fanpage',
                'category' => 'checkin_fanpage',
                'description' => 'Tăng check-in cho fanpage',
            ],
            [
                'name' => 'Sự kiện Facebook',
                'slug' => 'event-facebook',
                'category' => 'event_facebook',
                'description' => 'Tăng tham gia / quan tâm sự kiện',
            ],
            [
                'name' => 'VIP Like theo tháng',
                'slug' => 'vip-like-monthly',
                'category' => 'vip_like_monthly',
                'description' => 'Gói VIP like theo tháng',
            ],
            [
                'name' => 'VIP Like group theo tháng',
                'slug' => 'vip-like-group-monthly',
                'category' => 'vip_like_group_monthly',
                'description' => 'Gói VIP like group theo tháng',
            ],
            [
                'name' => 'VIP Comment theo tháng',
                'slug' => 'vip-comment-monthly',
                'category' => 'vip_comment_monthly',
                'description' => 'Gói VIP comment theo tháng',
            ],
            [
                'name' => 'VIP Mắt theo tháng',
                'slug' => 'vip-eye-monthly',
                'category' => 'vip_eye_monthly',
                'description' => 'Gói VIP mắt theo tháng',
            ],
            [
                'name' => 'VIP View theo tháng',
                'slug' => 'vip-view-monthly',
                'category' => 'vip_view_monthly',
                'description' => 'Gói VIP view theo tháng',
            ],
            [
                'name' => 'VIP Share theo tháng',
                'slug' => 'vip-share-monthly',
                'category' => 'vip_share_monthly',
                'description' => 'Gói VIP share theo tháng',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

