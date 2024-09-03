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
        Schema::disableForeignKeyConstraints();

        Schema::table('product_variants', function (Blueprint $table) {

            $table->dropColumn('sku');
            $table->dropColumn('stock');
            $table->foreignId('sku_id')->constrained('product_variant_skus')->cascadeOnDelete()->cascadeOnUpdate();

        });
        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_variants', function (Blueprint $table) {

            $table->string('sku');
            $table->integer('stock');
            $table->dropForeign(['sku_id']);
            $table->dropColumn('sku_id');

        });
}
};
