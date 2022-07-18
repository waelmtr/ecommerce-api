<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->string('name');
            $table->text('image_Path');
            $table->date('expiration_Date');
            $table->Integer('firstDiscountDate');
            $table->double('firstDiscount');
            $table->Integer('secondDiscountDate');
            $table->double('secondDiscount');
            $table->Integer('thirdDiscountDate');
            $table->double('thirdDiscount');
            $table->text('description');
            $table->string('contact_Information');
            $table->Integer('Quantity')->default('1');
            $table->double('Price');
            $table->ForeignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->ForeignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->Integer('views')->default('0');
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
}
