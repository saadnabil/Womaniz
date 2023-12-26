<?php

use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_en')->nullable();
            $table->string('name_ar')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('desc_ar')->nullable();
            $table->string('thumbnail')->nullable();
            $table->double('price')->nullable();
            $table->double('price_after_sale')->nullable();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->double('discount')->default(0.00);

            $table->foreignId('designer_id')
                  ->nullable()
                  ->constrained('designers')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreignId('country_id')
                  ->nullable()
                  ->constrained('countries')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
};
