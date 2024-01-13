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
        Schema::create('spin_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('cascade')->onUpdate('cascade');
            $table->string('digit_one')->nullable();
            $table->string('digit_two')->nullable();
            $table->string('digit_three')->nullable();
            $table->string('digit_four')->nullable();
            $table->string('digit_five')->nullable();
            $table->string('digit_six')->nullable();
            $table->string('digit_seven')->nullable();
            $table->string('digit_eight')->nullable();
            $table->string('digit_nine')->nullable();
            $table->string('status')->default('on')->nullable();
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
        Schema::dropIfExists('spin_games');
    }
};
