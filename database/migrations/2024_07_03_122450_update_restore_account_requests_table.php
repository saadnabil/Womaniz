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
        Schema::table('restore_account_requests', function (Blueprint $table) {
            //
            $table->foreignId('user_id')
                ->constrained('users')
                ->nullable()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->text('rejection_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restore_account_requests', function (Blueprint $table) {
            //
        });
    }
};
