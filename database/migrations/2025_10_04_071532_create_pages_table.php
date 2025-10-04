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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('pages')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
            $table->string('link')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->string('type');
            $table->string('page_type')->nullable();
            $table->integer('order_id')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('feature')->default(1);

            $table->timestamps();
            $table->index('type');
            $table->index('page_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
