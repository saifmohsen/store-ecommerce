<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { // always use "create" instead of "table" in "Schema::____" to avoid mistakes
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->unique(); //name of setting item that i edit it
            $table->boolean('is_translatable')->default(false);
            $table->text('plain_value')->nullable(); // plain_value مثلا لو كان عندي توصيل داخلي ف قديش قيمة هاد التوصيل هي بتعبر عن  setting item  قيمة ال
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
        Schema::dropIfExists('settings');

    }
}
