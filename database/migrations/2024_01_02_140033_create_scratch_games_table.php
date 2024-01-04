<?php

use Carbon\Carbon;
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
        Schema::create('scratch_games', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->integer('discount')->default(0);
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
            $table->date('date')->nullable()->default(Carbon::now()->toDateString());
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
        Schema::dropIfExists('scratch_games');
    }
};
