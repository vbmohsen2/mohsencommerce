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
        Schema::create('post_bigbanners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Post_id')->constrained('posts');
            $table->tinyinteger('Position');
            $table->tinyinteger('Width');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_bigbanners');
    }
};
