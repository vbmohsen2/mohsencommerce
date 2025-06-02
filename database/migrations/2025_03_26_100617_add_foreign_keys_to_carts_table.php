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
        Schema::table('carts', function (Blueprint $table) {
            // اضافه کردن کلید خارجی برای user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // اضافه کردن کلید خارجی برای product_id
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
        });
    }
};
