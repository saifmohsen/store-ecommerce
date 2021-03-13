<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id'); //this is for main category
            $table->integer('parent_id')->nullable()->unsigned(); //this is for subcategory of main category
            $table->string('slug')->unique();
            $table->boolean('is_active') ;
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        }); // ربطنا الparent_id بالid ... طبعا الاتنين في نفس الجدول
        // لانه parent_id هو بارة عن subcategory لل id اللي هو  main category
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
