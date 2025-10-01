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
        Schema::create('user_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('phone', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('name_first', 191)->nullable();
            $table->string('name_last', 191)->nullable();
            $table->string('name', 191)->nullable();
            $table->string('username', 191)->nullable();
            $table->string('country_code', 191)->nullable();
            $table->string('code', 191)->nullable();
            $table->timestamp('code_expire')->nullable();
            $table->timestamps();
            $table->index('phone');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_codes');
    }
};
