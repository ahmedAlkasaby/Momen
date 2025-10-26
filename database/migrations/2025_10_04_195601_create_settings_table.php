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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            // 1. نضع 'type' أولاً
            $table->string('type')->default('text');
            
            // 2. نضع 'validation_rules' مباشرة بعد 'type' ونحذف after()
            $table->text('validation_rules')->nullable();
            
            $table->string('key')->unique();
            $table->string('value');
            $table->string('locale')->default('en');
            $table->tinyInteger('autoload')->default(0);
            $table->tinyInteger('order_id')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('settings')->onDelete('cascade');
            $table->timestamps();

            $table->index(['group', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
