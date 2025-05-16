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
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('property_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('value');
            $table->timestamps();
            $table->unique(['property_id', 'value']);
        });

        Schema::create('product_property_value', function (Blueprint $table) {
            $table->id(); // Добавляем id как первичный ключ
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('property_value_id')->constrained()->onDelete('cascade');
            $table->unique(['product_id', 'property_value_id']); // Уникальный индекс вместо первичного ключа
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_property_value');
        Schema::dropIfExists('property_values');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('products');
    }
};