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
       Schema::create('profiles', function (Blueprint $table) {
    $table->id();

    // Relationship with users table
    $table->foreignId('user_id')
          ->constrained()
          ->onDelete('cascade');

    $table->integer('id_number');
    $table->string('name');
    $table->string('email');
    $table->string('image')->nullable();

    $table->enum('gender', ['M', 'F']);

    $table->text('description')->nullable();

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
