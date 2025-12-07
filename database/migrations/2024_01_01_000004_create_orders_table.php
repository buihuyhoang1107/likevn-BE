<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('server_id')->constrained('servers')->onDelete('cascade');
            $table->string('action'); // Tên hành động
            $table->string('uid')->nullable(); // UID hoặc link
            $table->string('account_name')->nullable(); // Tên tài khoản
            $table->text('content')->nullable(); // Nội dung (cho bình luận, share)
            $table->text('note')->nullable(); // Ghi chú của user
            $table->text('admin_note')->nullable(); // Ghi chú của admin
            $table->integer('quantity'); // Số lượng
            $table->integer('ran')->default(0); // Đã chạy
            $table->decimal('price_per_unit', 10, 2); // Giá mỗi đơn vị
            $table->decimal('total_price', 15, 2); // Tổng giá
            $table->string('emotion')->nullable(); // Loại cảm xúc (like, love, etc.)
            $table->string('speed')->nullable(); // Tốc độ (nhanh, chậm, trung bình)
            $table->timestamp('started_at')->nullable(); // Bắt đầu
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled', 'failed'])->default('pending');
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

