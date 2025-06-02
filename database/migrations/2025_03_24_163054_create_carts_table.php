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
            $table->id(); // شناسه یکتا
            $table->unsignedBigInteger('user_id')->nullable(); // شناسه کاربر (در صورت نیاز به ثبت‌نام)
            $table->unsignedBigInteger('product_id'); // شناسه محصول
            $table->integer('quantity')->default(1); // تعداد محصول
            $table->timestamps(); // زمان ایجاد و بروزرسانی
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
