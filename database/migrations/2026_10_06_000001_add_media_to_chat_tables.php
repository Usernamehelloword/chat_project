<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add image / video attachment support to private and group chat.
     */
    public function up(): void
    {
        foreach (['text_private', 'group_chat'] as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'media_path')) {
                    $table->string('media_path')->nullable();
                }

                if (!Schema::hasColumn($tableName, 'media_type')) {
                    // 'image' or 'video'
                    $table->string('media_type', 10)->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (['text_private', 'group_chat'] as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $drop = array_values(array_filter(
                    ['media_path', 'media_type'],
                    fn ($column) => Schema::hasColumn($tableName, $column)
                ));

                if ($drop) {
                    $table->dropColumn($drop);
                }
            });
        }
    }
};
