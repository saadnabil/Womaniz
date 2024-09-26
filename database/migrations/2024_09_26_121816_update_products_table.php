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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['color_id']);
            $table->dropForeign(['size_id']);
            $table->dropColumn('color_id');
            $table->dropColumn('size_id');

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

            $table->foreignId('size_id')
                ->nullable()
                ->constrained('sizes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('color_id')
                ->nullable()
                ->constrained('colors')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }
};
