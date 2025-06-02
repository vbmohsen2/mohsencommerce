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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attribute_template_id')->constrained()->onDelete('cascade');
            $table->string('name');                 // مثلا: "حافظه داخلی"
            $table->string('slug');                 // مثل: "ram" (برای ذخیره در JSON یا فیلتر)
            $table->string('input_type');           // text, number, select, boolean
            $table->json('options')->nullable();    // برای select ها
            $table->boolean('is_filterable')->default(true); // آیا در فیلتر دسته‌بندی نمایش داده شود؟
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
