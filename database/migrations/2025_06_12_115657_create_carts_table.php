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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // Link to students via user_id
            $table->unsignedBigInteger('user_id');

            // Link to uniforms via uniform_id (string)
            $table->string('uniform_id', 100)->collation('utf8mb4_unicode_ci');

            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('user_id')->on('student')->onDelete('cascade');
            $table->foreign('uniform_id')->references('uniform_id')->on('uniform')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
