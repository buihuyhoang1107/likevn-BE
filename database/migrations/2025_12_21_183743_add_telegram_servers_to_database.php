<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Server;
use App\Models\Service;

class AddTelegramServersToDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 53. Member & Sub Telegram
        $telegramMemberSub = Service::where('slug', 'telegram-member-sub')->first();
        if ($telegramMemberSub && !Server::where('code', 'TELEGRAM_MEMBER_S1')->exists()) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'TELEGRAM_MEMBER_S1',
                    'price_per_unit' => 36.9,
                    'status' => 'active',
                    'description' => 'Tốc độ 10k/24 giờ, Bảo hành 7 ngày cho đơn mua đầu tiên (vì vậy không chia nhỏ đơn hàng), có thể tụt vào thời điểm không xác định',
                    'min_quantity' => 200,
                    'max_quantity' => 40000,
                    'is_active' => true,
                    'features' => json_encode([
                        'id' => '475325',
                        'speed_per_day' => 10000,
                        'warranty_days' => 7,
                        'warranty_note' => 'Chỉ bảo hành cho đơn mua đầu tiên, không chia nhỏ đơn hàng',
                        'note' => 'Có thể tụt vào thời điểm không xác định',
                    ]),
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'TELEGRAM_MEMBER_S2',
                    'price_per_unit' => 68.8,
                    'status' => 'active',
                    'description' => 'Tốc độ 5k-10k/24 giờ, Bảo hành 7 ngày',
                    'min_quantity' => 200,
                    'max_quantity' => 40000,
                    'is_active' => true,
                    'features' => json_encode([
                        'speed_per_day' => [5000, 10000],
                        'warranty_days' => 7,
                    ]),
                ],
                [
                    'name' => 'Server 4',
                    'code' => 'TELEGRAM_MEMBER_S4',
                    'price_per_unit' => 34.4,
                    'status' => 'active',
                    'description' => 'Tốc độ 5k/24 giờ, Không bảo hành (tụt hết sau vài ngày)',
                    'min_quantity' => 200,
                    'max_quantity' => 40000,
                    'is_active' => true,
                    'features' => json_encode([
                        'speed_per_day' => 5000,
                        'warranty_days' => 0,
                        'note' => 'Tụt hết sau vài ngày, không bảo hành',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $telegramMemberSub->id,
                ]));
            }
        }

        // 54. View bài viết Telegram
        $telegramPostView = Service::where('slug', 'telegram-post-view')->first();
        if ($telegramPostView && !Server::where('code', 'TELEGRAM_VIEW_S1')->exists()) {
            $servers = [
                [
                    'name' => 'Server 1',
                    'code' => 'TELEGRAM_VIEW_S1',
                    'price_per_unit' => 1.9,
                    'status' => 'active',
                    'description' => 'Tốc độ lên chậm, số lượng mua phải chia hết cho 100, bài text thường lên sớm hơn, bài video và ảnh sẽ chậm hơn',
                    'min_quantity' => 500,
                    'max_quantity' => 1000000,
                    'is_active' => true,
                    'features' => json_encode([
                        'id' => '475392',
                        'require_divisible_by' => 100,
                        'note' => 'Số lượng mua phải chia hết cho 100 (ví dụ: 500, 600, 700...); bài text lên sớm hơn, video và ảnh chậm hơn',
                        'supported' => 'Chỉ hỗ trợ kênh, không hỗ trợ nhóm',
                    ]),
                ],
                [
                    'name' => 'Server 2',
                    'code' => 'TELEGRAM_VIEW_S2',
                    'price_per_unit' => 6.3,
                    'status' => 'active',
                    'description' => 'Siêu tốc, 1 bài',
                    'min_quantity' => 500,
                    'max_quantity' => 1000000,
                    'is_active' => true,
                    'features' => json_encode([
                        'speed' => 'super_fast',
                        'max_posts' => 1,
                        'supported' => 'Chỉ hỗ trợ kênh, không hỗ trợ nhóm',
                    ]),
                ],
                [
                    'name' => 'Server 3',
                    'code' => 'TELEGRAM_VIEW_S3',
                    'price_per_unit' => 3.8,
                    'status' => 'stopped',
                    'description' => 'Nhiều bài tùy chọn - Bảo trì',
                    'min_quantity' => 500,
                    'max_quantity' => 1000000,
                    'is_active' => false,
                    'features' => json_encode([
                        'note' => 'Đang bảo trì',
                        'maintenance' => true,
                        'supported' => 'Chỉ hỗ trợ kênh, không hỗ trợ nhóm',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $telegramPostView->id,
                ]));
            }
        }

        // 55. Cảm xúc bài viết Telegram
        $telegramPostReaction = Service::where('slug', 'telegram-post-reaction')->first();
        if ($telegramPostReaction && !Server::where('code', 'TELEGRAM_REACTION_S1')->exists()) {
            $servers = [
                [
                    'name' => 'Server 1 (Cảm xúc tích cực)',
                    'code' => 'TELEGRAM_REACTION_S1',
                    'price_per_unit' => 10,
                    'status' => 'active',
                    'description' => 'Cảm xúc tích cực ngẫu nhiên [👍🤩🎉🔥❤️🥰👏🏻]',
                    'min_quantity' => 50,
                    'max_quantity' => 500000,
                    'is_active' => true,
                    'features' => json_encode([
                        'id' => '475395',
                        'reaction_type' => 'positive',
                        'reactions' => ['👍', '🤩', '🎉', '🔥', '❤️', '🥰', '👏🏻'],
                        'note' => 'Có thể thiếu và không bảo hành, nên mua dư khi mua. Không hỗ trợ group',
                    ]),
                ],
                [
                    'name' => 'Server 2 (Cảm xúc tiêu cực)',
                    'code' => 'TELEGRAM_REACTION_S2',
                    'price_per_unit' => 10,
                    'status' => 'active',
                    'description' => 'Cảm xúc tiêu cực ngẫu nhiên [👎💩🤮😢😱]',
                    'min_quantity' => 50,
                    'max_quantity' => 500000,
                    'is_active' => true,
                    'features' => json_encode([
                        'reaction_type' => 'negative',
                        'reactions' => ['👎', '💩', '🤮', '😢', '😱'],
                        'note' => 'Có thể thiếu và không bảo hành, nên mua dư khi mua. Không hỗ trợ group',
                    ]),
                ],
            ];
            foreach ($servers as $server) {
                Server::create(array_merge($server, [
                    'service_id' => $telegramPostReaction->id,
                ]));
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Xóa Telegram servers nếu cần rollback
        Server::whereIn('code', [
            'TELEGRAM_MEMBER_S1',
            'TELEGRAM_MEMBER_S2',
            'TELEGRAM_MEMBER_S4',
            'TELEGRAM_VIEW_S1',
            'TELEGRAM_VIEW_S2',
            'TELEGRAM_VIEW_S3',
            'TELEGRAM_REACTION_S1',
            'TELEGRAM_REACTION_S2',
            'TELEGRAM_REACTION_S3',
        ])->delete();
    }
}
