<?php

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
        Schema::create('order_details_skus', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sku_id')
                ->nullable()
                ->constrained('product_variant_skus')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('order_details_id')
                ->nullable()
                ->constrained('order_details')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('order_details_skus');
    }
};
