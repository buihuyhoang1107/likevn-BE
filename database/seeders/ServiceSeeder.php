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
                'name' => 'Share Livestream Group',
                'slug' => 'share-live-group',
                'category' => 'share_live_group',
                'description' => 'Share livestream vào group',
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
            [
                'name' => 'Like Threads',
                'slug' => 'like-threads',
                'category' => 'threads_like',
                'description' => 'Like bài viết trên Threads',
            ],
            [
                'name' => 'Follow Threads',
                'slug' => 'follow-threads',
                'category' => 'threads_follow',
                'description' => 'Follow tài khoản trên Threads',
            ],
            [
                'name' => 'Like TikTok',
                'slug' => 'tiktok-like',
                'category' => 'tiktok_like',
                'description' => 'Tăng like (tim) cho bài viết TikTok',
            ],
            [
                'name' => 'Like Comment TikTok',
                'slug' => 'tiktok-like-comment',
                'category' => 'tiktok_like_comment',
                'description' => 'Tăng like cho bình luận TikTok',
            ],
            [
                'name' => 'Follow TikTok',
                'slug' => 'tiktok-follow',
                'category' => 'tiktok_follow',
                'description' => 'Tăng follow tài khoản TikTok',
            ],
            [
                'name' => 'View TikTok',
                'slug' => 'tiktok-view',
                'category' => 'tiktok_view',
                'description' => 'Tăng lượt xem TikTok',
            ],
            [
                'name' => 'Comment TikTok',
                'slug' => 'tiktok-comment',
                'category' => 'tiktok_comment',
                'description' => 'Tăng bình luận TikTok',
            ],
            [
                'name' => 'Share TikTok',
                'slug' => 'tiktok-share',
                'category' => 'tiktok_share',
                'description' => 'Tăng chia sẻ bài viết TikTok',
            ],
            [
                'name' => 'Save TikTok',
                'slug' => 'tiktok-save',
                'category' => 'tiktok_save',
                'description' => 'Tăng lượt lưu (yêu thích) TikTok',
            ],
            [
                'name' => 'Tim Livestream TikTok',
                'slug' => 'tiktok-live-like',
                'category' => 'tiktok_live_like',
                'description' => 'Tăng tim cho livestream TikTok',
            ],
            [
                'name' => 'Share Livestream TikTok',
                'slug' => 'tiktok-live-share',
                'category' => 'tiktok_live_share',
                'description' => 'Tăng share cho livestream TikTok',
            ],
            [
                'name' => 'Comment Livestream TikTok',
                'slug' => 'tiktok-live-comment',
                'category' => 'tiktok_live_comment',
                'description' => 'Tăng comment cho livestream TikTok',
            ],
            [
                'name' => 'Mắt Livestream TikTok',
                'slug' => 'tiktok-live-eye',
                'category' => 'tiktok_live_eye',
                'description' => 'Tăng mắt xem livestream TikTok',
            ],
            [
                'name' => 'PK Livestream TikTok',
                'slug' => 'tiktok-live-pk',
                'category' => 'tiktok_live_pk',
                'description' => 'Tăng điểm chiến đấu (PK) livestream TikTok',
            ],
            [
                'name' => 'VIP Love TikTok',
                'slug' => 'tiktok-vip-like',
                'category' => 'tiktok_vip_like',
                'description' => 'Gói VIP tim TikTok theo tháng',
            ],
            [
                'name' => 'VIP View TikTok',
                'slug' => 'tiktok-vip-view',
                'category' => 'tiktok_vip_view',
                'description' => 'Gói VIP view TikTok theo tháng',
            ],
            [
                'name' => 'Follow Shopee',
                'slug' => 'shopee-follow',
                'category' => 'shopee_follow',
                'description' => 'Tăng follow shop Shopee',
            ],
            [
                'name' => 'Love Shopee',
                'slug' => 'shopee-love',
                'category' => 'shopee_love',
                'description' => 'Tăng love cho sản phẩm Shopee',
            ],
            [
                'name' => 'Like Review Shopee',
                'slug' => 'shopee-like-review',
                'category' => 'shopee_like_review',
                'description' => 'Tăng like cho review Shopee',
            ],
            [
                'name' => 'Mắt Livestream Shopee',
                'slug' => 'shopee-live-eye',
                'category' => 'shopee_live_eye',
                'description' => 'Tăng mắt xem livestream Shopee',
            ],
            [
                'name' => 'Member & Sub Telegram',
                'slug' => 'telegram-member-sub',
                'category' => 'telegram_member_sub',
                'description' => 'Tăng member và subscriber cho nhóm Telegram',
            ],
            [
                'name' => 'View bài viết Telegram',
                'slug' => 'telegram-post-view',
                'category' => 'telegram_post_view',
                'description' => 'Tăng lượt xem bài viết trên kênh Telegram (chỉ hỗ trợ kênh, không hỗ trợ nhóm)',
            ],
            [
                'name' => 'Cảm xúc bài viết Telegram',
                'slug' => 'telegram-post-reaction',
                'category' => 'telegram_post_reaction',
                'description' => 'Tăng cảm xúc (reaction) cho bài viết Telegram',
            ],
            [
                'name' => 'Like Youtube',
                'slug' => 'youtube-like',
                'category' => 'youtube_like',
                'description' => 'Tăng like cho video YouTube',
            ],
            [
                'name' => 'View Youtube',
                'slug' => 'youtube-view',
                'category' => 'youtube_view',
                'description' => 'Tăng lượt xem cho video YouTube',
            ],
            [
                'name' => 'View Youtube (400H)',
                'slug' => 'youtube-view-400h',
                'category' => 'youtube_view_400h',
                'description' => 'Tăng view YouTube 400 giờ, yêu cầu video thời lượng từ 5-45 phút',
            ],
            [
                'name' => 'Live Stream Youtube',
                'slug' => 'youtube-live-stream',
                'category' => 'youtube_live_stream',
                'description' => 'Tăng mắt xem livestream YouTube',
            ],
            [
                'name' => 'Like Youtube (400H)',
                'slug' => 'youtube-like-400h',
                'category' => 'youtube_like_400h',
                'description' => 'Tăng like YouTube 400 giờ, yêu cầu video thời lượng từ 5-45 phút',
            ],
            [
                'name' => 'Comment Youtube',
                'slug' => 'youtube-comment',
                'category' => 'youtube_comment',
                'description' => 'Tăng bình luận cho video YouTube',
            ],
            [
                'name' => 'Like Comment Youtube',
                'slug' => 'youtube-like-comment',
                'category' => 'youtube_like_comment',
                'description' => 'Tăng like cho bình luận YouTube',
            ],
            [
                'name' => 'Subscribe Youtube',
                'slug' => 'youtube-subscribe',
                'category' => 'youtube_subscribe',
                'description' => 'Tăng subscriber cho kênh YouTube',
            ],
            // Twitter Services
            [
                'name' => 'Like Twitter',
                'slug' => 'twitter-like',
                'category' => 'twitter_like',
                'description' => 'Like bài viết Twitter',
            ],
            [
                'name' => 'Follow Twitter',
                'slug' => 'twitter-follow',
                'category' => 'twitter_follow',
                'description' => 'Follow tài khoản Twitter',
            ],
            [
                'name' => 'View Twitter',
                'slug' => 'twitter-view',
                'category' => 'twitter_view',
                'description' => 'Tăng view cho bài viết Twitter',
            ],
            [
                'name' => 'ReTweet Twitter',
                'slug' => 'twitter-retweet',
                'category' => 'twitter_retweet',
                'description' => 'Retweet bài viết Twitter',
            ],
            [
                'name' => 'Comment Twitter',
                'slug' => 'twitter-comment',
                'category' => 'twitter_comment',
                'description' => 'Tăng comment cho bài viết Twitter',
            ],
            [
                'name' => 'Livestream Twitter',
                'slug' => 'twitter-live-stream',
                'category' => 'twitter_live_stream',
                'description' => 'Mắt xem livestream Twitter',
            ],
            [
                'name' => 'VIP Like Twitter',
                'slug' => 'twitter-vip-like',
                'category' => 'twitter_vip_like',
                'description' => 'VIP Like Twitter theo tháng',
            ],
            [
                'name' => 'VIP View Twitter',
                'slug' => 'twitter-vip-view',
                'category' => 'twitter_vip_view',
                'description' => 'VIP View Twitter theo tháng',
            ],
            // Lazada
            [
                'name' => 'Sub Lazada',
                'slug' => 'lazada-sub',
                'category' => 'lazada_sub',
                'description' => 'Tăng sub cho shop Lazada',
            ],
            // Google Services
            [
                'name' => 'Google Maps',
                'slug' => 'google-map-create',
                'category' => 'google_map_create',
                'description' => 'Tạo Google Maps mới',
            ],
            [
                'name' => 'RIP Google Map',
                'slug' => 'google-map-rip',
                'category' => 'google_map_rip',
                'description' => 'RIP Google Map',
            ],
            [
                'name' => 'Review 5* Google Map',
                'slug' => 'google-map-review',
                'category' => 'google_map_review',
                'description' => 'Review 5 sao cho Google Map',
            ],
            // Unlock Facebook
            [
                'name' => 'Mở khóa FB',
                'slug' => 'unlock-facebook',
                'category' => 'unlock_facebook',
                'description' => 'Dịch vụ mở khóa, khôi phục và xử lý sự cố tài khoản Facebook',
            ],
            // Fanpage Services
            [
                'name' => 'Đổi tên Fanpage',
                'slug' => 'fanpage-rename',
                'category' => 'fanpage_rename',
                'description' => 'Dịch vụ đổi tên Fanpage Facebook',
            ],
            [
                'name' => 'Kháng gậy Fanpage',
                'slug' => 'fanpage-appeal',
                'category' => 'fanpage_appeal',
                'description' => 'Dịch vụ kháng gậy, kháng vi phạm cho Fanpage Facebook',
            ],
            [
                'name' => 'Nuôi thuê Fanpage',
                'slug' => 'fanpage-care',
                'category' => 'fanpage_care',
                'description' => 'Dịch vụ nuôi thuê, chăm sóc nội dung Fanpage',
            ],
            [
                'name' => 'Tăng Like Fanpage SL lớn',
                'slug' => 'fanpage-big-like',
                'category' => 'fanpage_big_like',
                'description' => 'Dịch vụ tăng Like Fanpage số lượng lớn',
            ],
            // Telegram services
            [
                'name' => 'Telegram - Tăng thành viên/Sub (channel)',
                'slug' => 'telegram-member-channel',
                'category' => 'telegram_member_channel',
                'description' => 'Tăng thành viên/Sub cho channel/group Telegram',
            ],
            [
                'name' => 'Telegram - Tăng view bài viết',
                'slug' => 'telegram-view-post',
                'category' => 'telegram_view_post',
                'description' => 'Tăng view cho bài viết Telegram',
            ],
            [
                'name' => 'Telegram - Tăng member online',
                'slug' => 'telegram-member-online',
                'category' => 'telegram_member_online',
                'description' => 'Tăng member online cho group Telegram',
            ],
            [
                'name' => 'Telegram - Tăng cảm xúc bài viết',
                'slug' => 'telegram-reaction',
                'category' => 'telegram_reaction',
                'description' => 'Tăng reaction cho bài viết Telegram',
            ],
            [
                'name' => 'Telegram - Dịch vụ nâng sao',
                'slug' => 'telegram-star',
                'category' => 'telegram_star',
                'description' => 'Dịch vụ nâng sao Telegram',
            ],
            [
                'name' => 'Telegram - Mua nhóm/kênh mới',
                'slug' => 'telegram-group-sale',
                'category' => 'telegram_group_sale',
                'description' => 'Mua nhóm/kênh Telegram (2k, 3k, 5k, 10k)',
            ],
            [
                'name' => 'Telegram - Mua tài khoản',
                'slug' => 'telegram-account-sale',
                'category' => 'telegram_account_sale',
                'description' => 'Mua tài khoản Telegram (new & cổ)',
            ],
            [
                'name' => 'Telegram - Mua kênh',
                'slug' => 'telegram-channel-sale',
                'category' => 'telegram_channel_sale',
                'description' => 'Mua kênh Telegram',
            ],
            [
                'name' => 'Telegram - Kéo mem theo yêu cầu',
                'slug' => 'telegram-custom-member',
                'category' => 'telegram_custom_member',
                'description' => 'Kéo member vào nhóm theo yêu cầu',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

