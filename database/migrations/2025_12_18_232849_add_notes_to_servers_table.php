<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddNotesToServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servers', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('description');
        });

        // Migrate dữ liệu từ features.notes sang field notes mới
        $servers = DB::table('servers')->get();
        foreach ($servers as $server) {
            if ($server->features) {
                $features = json_decode($server->features, true);
                if (is_array($features) && isset($features['notes']) && is_array($features['notes'])) {
                    // Chuyển array notes thành text, mỗi note một dòng
                    $notesText = implode("\n", $features['notes']);
                    DB::table('servers')
                        ->where('id', $server->id)
                        ->update(['notes' => $notesText]);
                }
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
        Schema::table('servers', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
}
