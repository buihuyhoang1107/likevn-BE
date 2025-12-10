<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateServiceCategories extends Migration
{
    public function up()
    {
        // Thêm các category mới cho cột category của bảng services
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
                'vip_share_monthly'
            ) NOT NULL
        ");
    }

    public function down()
    {
        // Quay lại danh sách cũ (không bao gồm các category mới)
        DB::statement("
            ALTER TABLE `services`
            MODIFY COLUMN `category` ENUM(
                'like_post_speed',
                'like_post_vip',
                'sub_personal_fanpage',
                'like_fanpage',
                'like_comment',
                'increase_comment',
                'share_post'
            ) NOT NULL
        ");
    }
}

