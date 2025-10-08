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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('content')->nullable();
            $table->string('code')->unique();
            $table->string('type'); 
            $table->decimal('discount');
            $table->decimal('max_discount');
            $table->decimal('min_order');
            $table->integer('user_limit')->default(1);
            $table->integer('use_limit')->default(1);
            $table->integer('use_count')->default(0);
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_expire')->nullable();
            $table->date('day_start')->nullable();            
            $table->date('day_expire')->nullable();
            $table->integer('order_id')->default(1);
            $table->tinyInteger('finish')->default(0);
            $table->tinyInteger('active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
