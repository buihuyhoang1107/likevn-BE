<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddThreadsCategoriesToServicesTable extends Migration
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
                'threads_follow'
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
                'instagram_vip_comment'
            ) NOT NULL
        ");
    }
}
