<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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

            $table->foreignId('designer_id')->nullable()->constrained('designers')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('country_id')->nullable()->constrained('countries')->onUpdate('cascade')->onDelete('cascade');

            $table->string('product_type')->nullable();

            $table->string('product_sub_type')->nullable();

            $table->string('vat')->default(0)->nullable();

            $table->foreignId('size_id')->nullable()->constrained('sizes')->onUpdate('cascade')->onDelete('cascade');

            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('cascade')->onUpdate('cascade');

            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->onDelete('cascade')->onUpdate('cascade');

            $table->string('seller_sku')->nullable();

            $table->string('status')->default('live');

            $table->string('model_id')->nullable();

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
