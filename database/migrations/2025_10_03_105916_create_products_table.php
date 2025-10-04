<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('link')->nullable();

            $table->text('name');
            $table->longText('content')->nullable();
            // image
            $table->string('image');
            $table->string('video')->nullable();
            $table->string('background')->nullable();
            $table->string('color')->nullable();

            // offer
            $table->string('offer_type')->nullable();
            $table->double('offer_price')->nullable();
            $table->double('offer_amount')->nullable();
            $table->double('offer_amount_add')->nullable();
            $table->double('offer_percent')->nullable();

            //price
            $table->double('price');
            $table->double('price_start')->default(0);
            $table->double('price_end')->default(0);


            $table->double('shipping')->default(0);


            //order limit
            $table->double('start')->default(1);
            $table->double('skip')->default(1);
            $table->double('order_limit')->default(1);
            $table->double('max_order')->default(1);

            // rating
            $table->integer('rate_count')->default(0);
            $table->double('rate_all')->default(0);
            $table->double('rate')->default(0);





            // status
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('is_stock')->default(0);
            $table->tinyInteger('is_filter')->default(0);
            $table->tinyInteger('is_offer')->default(0);
            $table->tinyInteger('is_sale')->default(0);
            $table->tinyInteger('is_new')->default(0);
            $table->tinyInteger('is_special')->default(0);
            $table->tinyInteger('is_late')->default(0);
            $table->tinyInteger('is_size')->default(0);
            $table->tinyInteger('is_color')->default(0);
            $table->tinyInteger('is_max')->default(0);
            $table->tinyInteger('is_shipping_free')->default(0);
            $table->tinyInteger('is_returned')->default(0);


            // dates
            $table->timestamp('date_start')->nullable();
            $table->timestamp('date_expire')->nullable();
            $table->string('day_start')->nullable();
            $table->string('day_expire')->nullable();
            $table->string('prepare_time')->nullable();




            // relations
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->foreignId('size_id')->nullable()->constrained('sizes')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('products')->nullOnDelete();

            // order
            $table->integer('order_id')->nullable();


            $table->timestamps();
            $table->softDeletes();

            // $table->index(['active', 'is_stock', 'is_filter', 'is_offer', 'is_sale', 'is_new',
            //  'is_special', 'is_late', 'is_size', 'is_color', 'is_max', 
            //  'is_shipping_free', 'is_returned'
            // ]);
            // $table->index(['code', 'name','link', 'content', 'offer_type', 'offer_price',
            // 'price',
            // 'shipping', 'order_limit', 'max_order',
            // 'rate_count', 'rate_all', 'rate'
            // ]);
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
