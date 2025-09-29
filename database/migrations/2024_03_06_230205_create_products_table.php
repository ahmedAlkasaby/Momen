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
            $table->string('image');
            $table->string('slug');
            $table->longText('description')->nullable()->default('text');
            $table->text('short_description')->nullable()->default('text');
            $table->integer('price');
            $table->integer('selling_price');
            $table->tinyInteger('trend')->nullble()->default(0);
            $table->tinyInteger('showing')->nullble()->default(0);
            $table->timestamps();
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
