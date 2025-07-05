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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longtext('description');
            $table->decimal('price',12,2);
            $table->decimal('discount_price',12,2)->nullable();
            $table->unsignedInteger('stock');
            $table->string('sku')->unique()->nullable();
            $table->foreignId('category_id')->constrained();
            $table->boolean('is_active')->default(true);
            $table->json('images')->nullable();
            $table->string('brand')->nullable();
            $table->float('weight',8,2)->nullable();
            $table->decimal('dimension',8,2)->nullable();
            $table->json('attributes')->nullable();
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
