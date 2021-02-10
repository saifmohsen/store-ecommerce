<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('setting_id')->unsigned(); //foreign key عشان اربطه مع جدول الاعدادات الاساسي
            //unsigned يعني انه لا سالب ولا موجب ملهاش اشارة
            $table->string('locale'); //اللغة المستخدمة...  طبعا هاد العمود اساسي من الباكيج تعت الترجممة نفسها يعني لازم نعملو
            $table->longText('value')->nullable();

            $table->unique(['setting_id', 'locale']);
            //  locale و setting_id انه ممنوع يتكرر وكمان بينفع اعمل كل واحد لحال يعني اكتب يونيك لل
            //بينفع اكتبهن فوق في جملهن لكن عشان اكتر من جملة الها يونيك بينفع اعملهن مع بعض
            $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');
            //انه الفوريجن كيي بيشاور ع العمود اللي اسمه اي دي في جدول السيتينغس
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_translations');
    }
}
