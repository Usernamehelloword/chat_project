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
           Schema::create('add_friends', function (Blueprint $table) {

            $table->id();  
            $table->integer('chat_id')->default(0);
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('friend_id')->default(0);
            $table->string('group_name')->default('0');

                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
