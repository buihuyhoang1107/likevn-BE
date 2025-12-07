<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->string('full_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('ref_code')->nullable();
            $table->string('password');
            $table->enum('type', ['user', 'agent', 'collaborator'])->default('user');
            $table->decimal('balance', 15, 2)->default(0);
            $table->decimal('monthly_deposit', 15, 2)->default(0);
            $table->integer('level')->default(1);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

