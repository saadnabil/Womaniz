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
        Schema::create('scratch_game_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('scratch_game_id')->nullable()->constrained('scratch_games')->onDelete('cascade')->onUpdate('cascade');
            $table->date('date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->tinyInteger('open_cell_index')->defaul(0);
            $table->tinyInteger('time_open_cell_index')->defaul(0);
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
        Schema::dropIfExists('scratch_game_users');
    }
};
