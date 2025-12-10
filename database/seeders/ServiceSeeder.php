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
            [
                'name' => 'Buff mắt Livestream V2',
                'slug' => 'buff-mat-livestream-v2',
                'category' => 'eye_live_view_video',
                'description' => 'Mắt xem livestream Facebook V4 ~30 phút, yêu cầu link chứa từ "Videos"',
            ],
            [
                'name' => 'Tăng View video',
                'slug' => 'tang-view-video',
                'category' => 'eye_live_view_video',
                'description' => 'Buff view video, hỗ trợ play khi bị ẩn view, video <1 phút sẽ lên chậm',
            ],
            [
                'name' => 'Tăng View Story',
                'slug' => 'tang-view-story',
                'category' => 'eye_live_view_video',
                'description' => 'View Story, không mua trùng khi đơn chưa đủ, nên mua ngay sau khi đăng',
            ],
            [
                'name' => 'View 600k phút',
                'slug' => 'view-600k-phut',
                'category' => 'eye_live_view_video',
                'description' => 'Gói 600k phút, video ≥60 phút, thường hoàn thành trong 1-2 ngày',
            ],
            [
                'name' => 'View 60K offline',
                'slug' => 'view-60k-offline',
                'category' => 'eye_live_view_video',
                'description' => 'Gói 60K phút offline, ưu tiên lên nhanh, yêu cầu độ dài video đủ theo gói',
            ],
            [
                'name' => 'View 60K Live',
                'slug' => 'view-60k-live',
                'category' => 'eye_live_view_video',
                'description' => 'Gói 60K phút cho live, ưu tiên lên nhanh, hoàn thành trong ngày',
            ],
            [
                'name' => 'Tăng view 100k Reels',
                'slug' => 'tang-view-100k-reels',
                'category' => 'eye_live_view_video',
                'description' => 'Buff view Reels 100k, nhập đúng link/uid, sai không hoàn tiền',
            ],
            [
                'name' => 'Lọc bạn bè không tương tác',
                'slug' => 'loc-ban-be-khong-tuong-tac',
                'category' => 'friend_cleanup',
                'description' => 'Lọc bạn bè không tương tác, nhập link/ID và tên tài khoản cần xử lý',
            ],
            [
                'name' => 'Like Instagram',
                'slug' => 'like-instagram',
                'category' => 'instagram_like',
                'description' => 'Tăng like bài viết Instagram (link https://www.instagram.com/p/id/)',
            ],
            [
                'name' => 'Comment Instagram',
                'slug' => 'comment-instagram',
                'category' => 'instagram_comment',
                'description' => 'Tăng bình luận cho bài viết Instagram (link https://www.instagram.com/p/id/)',
            ],
            [
                'name' => 'Follow Instagram',
                'slug' => 'follow-instagram',
                'category' => 'instagram_follow',
                'description' => 'Tăng follow Instagram, sub Việt/Tây theo tốc độ từng server',
            ],
            [
                'name' => 'View Instagram',
                'slug' => 'view-instagram',
                'category' => 'instagram_view',
                'description' => 'Tăng view Video/REEL/IGTV/Story Instagram',
            ],
            [
                'name' => 'Mắt Livestream Instagram',
                'slug' => 'mat-livestream-instagram',
                'category' => 'instagram_live_eye',
                'description' => 'Mắt livestream Instagram, nhiều gói view/mắt theo ngày',
            ],
            [
                'name' => 'VIP Like Instagram',
                'slug' => 'vip-like-instagram',
                'category' => 'instagram_vip_like',
                'description' => 'Gói VIP like Instagram theo tháng/bài mỗi ngày',
            ],
            [
                'name' => 'VIP Comment Instagram',
                'slug' => 'vip-comment-instagram',
                'category' => 'instagram_vip_comment',
                'description' => 'Gói VIP comment Instagram theo tháng, chọn số cmt/bài mỗi ngày',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

