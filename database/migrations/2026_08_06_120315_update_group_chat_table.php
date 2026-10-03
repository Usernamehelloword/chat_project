<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('group_chat') && !Schema::hasColumn('group_chat', 'message')) {
            Schema::table('group_chat', function (Blueprint $table) {
                $table->text('message')->after('group_name')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('group_chat.php', function (Blueprint $table) {
            //
        });
    }
};
