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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('product_child_id')->nullable()->constrained('products')->nullOnDelete();

            $table->double('offer_price')->nullable();
            $table->double('price')->default(1);
            $table->double('amount')->default(1);
            $table->double('price_addition')->default(0);
            $table->double('amount_addition')->nullable()->default(0);
            $table->double('offer_amount')->default(0);
            $table->double('offer_amount_add')->default(0);
            $table->double('free_amount')->nullable();
            $table->double('total_amount')->default(1);
            $table->double('shipping')->default(0);
            $table->double('total')->default(1);
            $table->double('total_price')->nullable()->default(1);

            $table->tinyInteger('is_return')->default(0);
            $table->dateTime('return_at')->nullable();

            $table->timestamps();
            $table->softDeletes();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
