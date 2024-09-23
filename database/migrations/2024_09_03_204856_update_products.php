<?php

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
        Schema::table('products', function (Blueprint $table) {

            Schema::table('products', function (Blueprint $table) {
                // Step 1: Add the seller_sku column as nullable initially
                $table->string('seller_sku')->nullable();
            });
            DB::statement('UPDATE products SET seller_sku = CONCAT("sku_", id)');
            Schema::table('products', function (Blueprint $table) {
                $table->string('seller_sku')->unique()->nullable(false)->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('seller_sku');
        });
    }
};
