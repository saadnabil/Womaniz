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
            //
            DB::statement('ALTER TABLE products CHANGE COLUMN metal_en material_en VARCHAR(255)');
            DB::statement('ALTER TABLE products CHANGE COLUMN metal_ar material_ar VARCHAR(255)');
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
            //
            DB::statement('ALTER TABLE products CHANGE COLUMN material_en metal_en VARCHAR(255)');
            DB::statement('ALTER TABLE products CHANGE COLUMN material_ar metal_ar VARCHAR(255)');
        });
    }
};
