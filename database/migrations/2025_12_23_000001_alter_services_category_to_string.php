<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterServicesCategoryToString extends Migration
{
    public function up()
    {
        // Chuyển cột category từ enum sang VARCHAR để hỗ trợ thêm dịch vụ mới (Telegram, v.v.)
        DB::statement("ALTER TABLE services MODIFY category VARCHAR(100)");
    }

    public function down()
    {
        // Quay lại enum cũ (các giá trị ban đầu). Nếu có thêm category mới, cần cập nhật lại danh sách.
        DB::statement("
            ALTER TABLE services MODIFY category ENUM(
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
            )
        ");
    }
}


