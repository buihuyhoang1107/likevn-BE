<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddAdminTypeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modify enum to include 'admin'
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `type` ENUM('user', 'agent', 'collaborator', 'admin') DEFAULT 'user'");
        
        // Set user with id = 1 to admin type
        DB::table('users')->where('id', 1)->update(['type' => 'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Set admin users back to user type
        DB::table('users')->where('type', 'admin')->update(['type' => 'user']);
        
        // Remove 'admin' from enum
        DB::statement("ALTER TABLE `users` MODIFY COLUMN `type` ENUM('user', 'agent', 'collaborator') DEFAULT 'user'");
    }
}
