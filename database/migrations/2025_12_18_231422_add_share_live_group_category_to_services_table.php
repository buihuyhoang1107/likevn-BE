<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddShareLiveGroupCategoryToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            ALTER TABLE `services`
            MODIFY COLUMN `category` ENUM(
                'like_post_speed',
                'like_post_vip',
                'sub_personal_fanpage',
                'like_fanpage',
                'like_comment',
                'increase_comment',
                'share_post',
                'share_live_group',
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
                'instagram_like',
                'instagram_comment',
                'instagram_follow',
                'instagram_view',
                'instagram_live_eye',
                'instagram_vip_like',
                'instagram_vip_comment',
                'threads_like',
                'threads_follow',
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
                'shopee_follow',
                'shopee_love',
                'shopee_like_review',
                'shopee_live_eye',
                'telegram_member_sub',
                'telegram_post_view',
                'telegram_post_reaction',
                'youtube_like',
                'youtube_view',
                'youtube_view_400h',
                'youtube_live_stream',
                'youtube_like_400h',
                'youtube_comment',
                'youtube_like_comment',
                'youtube_subscribe',
                'twitter_like',
                'twitter_follow',
                'twitter_view',
                'twitter_retweet',
                'twitter_comment',
                'twitter_live_stream',
                'twitter_vip_like',
                'twitter_vip_view',
                'lazada_sub',
                'google_map_create',
                'google_map_rip',
                'google_map_review',
                'unlock_facebook',
                'fanpage_rename',
                'fanpage_appeal',
                'fanpage_care',
                'fanpage_big_like'
            ) NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            ALTER TABLE `services`
            MODIFY COLUMN `category` ENUM(
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
                'instagram_like',
                'instagram_comment',
                'instagram_follow',
                'instagram_view',
                'instagram_live_eye',
                'instagram_vip_like',
                'instagram_vip_comment',
                'threads_like',
                'threads_follow',
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
                'shopee_follow',
                'shopee_love',
                'shopee_like_review',
                'shopee_live_eye',
                'telegram_member_sub',
                'telegram_post_view',
                'telegram_post_reaction',
                'youtube_like',
                'youtube_view',
                'youtube_view_400h',
                'youtube_live_stream',
                'youtube_like_400h',
                'youtube_comment',
                'youtube_like_comment',
                'youtube_subscribe',
                'twitter_like',
                'twitter_follow',
                'twitter_view',
                'twitter_retweet',
                'twitter_comment',
                'twitter_live_stream',
                'twitter_vip_like',
                'twitter_vip_view',
                'lazada_sub',
                'google_map_create',
                'google_map_rip',
                'google_map_review',
                'unlock_facebook',
                'fanpage_rename',
                'fanpage_appeal',
                'fanpage_care',
                'fanpage_big_like'
            ) NOT NULL
        ");
    }
}
