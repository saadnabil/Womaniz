<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('desc_ar')->nullable();
            $table->string('thumbnail')->nullable();
            $table->double('price')->nullable();
            $table->double('price_after_sale')->nullable();
            $table->double('discount')->default(0.00);

            $table->string('product_type')->nullable();

            $table->foreignId('designer_id')
                  ->nullable()
                  ->constrained('designers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreignId('country_id')
                  ->nullable()
                  ->constrained('countries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

                  $table->foreignId('size_id')
                  ->nullable()
                  ->constrained('sizes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->text('fit_size_desc_en')->nullable();
            $table->text('fit_size_desc_ar')->nullable();

            $table->text('ship_information_desc_en')->nullable();
            $table->text('ship_information_desc_ar')->nullable();

            $table->text('return_order_desc_en')->nullable();
            $table->text('return_order_desc_ar')->nullable();

            $table->text('ingredients_desc_en')->nullable();
            $table->text('ingredients_desc_ar')->nullable();

            $table->text('about_product_desc_en')->nullable();
            $table->text('about_product_desc_ar')->nullable();

            $table->text('dimension')->nullable();

            $table->text('diamond_en')->nullable();
            $table->text('diamond_ar')->nullable();

            $table->text('metal_en')->nullable();
            $table->text('metal_ar')->nullable();

            $table->integer('chain_length')->nullable();

            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('cascade')->onUpdate('cascade');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
