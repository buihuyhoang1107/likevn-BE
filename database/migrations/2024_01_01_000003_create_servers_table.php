<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->decimal('price_per_unit', 10, 2);
            $table->enum('status', ['active', 'slow', 'stopped'])->default('active');
            $table->integer('min_quantity')->default(1);
            $table->integer('max_quantity')->nullable();
            $table->text('features')->nullable(); // JSON field for additional features
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('servers');
    }
}

