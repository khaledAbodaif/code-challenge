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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->decimal('stock_quantity', 10, 2)->comment('for the current stock');
            $table->decimal('initial_stock_quantity', 10, 2)->comment('for the stock capacity');
            $table->boolean('stock_alert_sent')->default(false);
            $table->enum('unit', UnitEnum::values())->default(UnitEnum::KILOGRAM);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients');
    }
};
