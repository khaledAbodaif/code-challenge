<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UnitEnum;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingredient_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 10, 2);
            $table->enum('unit', UnitEnum::values())->default(UnitEnum::GRAM);

            $table->timestamps();

            $table->unique(['product_id', 'ingredient_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_product');
    }
};
