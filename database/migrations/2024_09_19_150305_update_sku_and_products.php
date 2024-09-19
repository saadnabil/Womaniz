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
        Schema::table('colors', function (Blueprint $table) {
            $table->dropColumn('name_en');
            $table->dropColumn('name_ar');
        });

        Schema::table('product_variant_skus', function (Blueprint $table) {
            $table->float('price_after_sale');
            $table->float('discount');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('stock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('colors', function (Blueprint $table) {
            $table->string('color_en')->nullable();
            $table->string('color_ar')->nullable();
            });

            Schema::table('product_variant_skus', function (Blueprint $table) {
                $table->dropColumn('price_after_sale');
                $table->dropColumn('discount');
            });

            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('stock');
            });

    }
};
