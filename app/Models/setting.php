<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class setting extends Model
{

    use Translatable;//
    // هاي عشان استخدم هاي الباكيج عشان قصص الترجمة
    // طبعا هاد الامر بيعملي relation بين ال settingTranslation و setting
// ع اساس انه اي query بستخدمها ع هاد المودل يرجعلي كل الترجمات تاعتها
// Translatable is a trait file, and you can use it by click on ctrlul + mouse
// طبعا لو كتبت اي method هان بنفس اسم method الموجودة في trait راح يظهر exception

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
    // هاد عشان يرجعلي الترجمات ... يعني مثلا كلمة سعر المنتج الها ترجمة بالانجليزي والايطالي يروح يرجعلي كل ترجماتها

    protected $translatedAttributes = ['value'];

//طبعا هاي بحدد فيها الاعمدة اللي راح تحتوي على ترجمة الاعمدة في هاد المودل
             //  مثلا ترجمة الاعمدة في هاد المودل راح يتم تخزينها في جدول settingTranslation وتحديدا في عمود value
                                                    //عشان هيك حطينا في $translatedAttributes بس عمود value

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'is_translatable', 'plain_value'];
    // طبعا هاي الشغلات اللي بقدر اعدل عليها واضيف واحذف وهكذا

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_translatable' => 'boolean',
    ];
    // ال casting يعني عندي في عمود is_translatable القيمة اللي متخزنة فيه عبارة عن 0 , 1
    // وانا بدي ارجعها true or flase بدلا من 0 , 1 ف عملتلها casting
// يعني الcasting بيعمل تغيير للنوع
//يعني لما بدي ارجع بيانات واغير نوعها او اغير نوع بيانات من الجدول بستخدم الcasting للاعمدة اللي بدي ياها وبعطيها النوع او الانواع اللي بدي احولها الها


    /**
     * Set the given settings.
     *
     * @param array $settings
     * @return void
     */
    public static function setMany($settings)   // طبعا هاد الفنكشن اللي راح استخدمها في Seeder عشان اضيف البيانات في الداتابيز
        //طبعا هاي الفنكشن الاسم وهي انا عملتها من عندي
        //ال $settings عبارة عن متغير وهاد المتغير راح يكون عبارة عن array

    {
        foreach ($settings as $key => $value) {
            self::set($key, $value);
        } //طبعا استخدمت Self لانه عندي في الفنكشن static
         //طبعا Self تشير الى نفس او هاد الكلاسيعني لنفس المودل
        //ال set عبارة عن ميثود انا برضو عملتها

    }


    /**
     * Set the given setting.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    //  defaultlocal , ar
    public static function set($key, $value)
    {
        if ($key === 'translatable') {
            return static::setTranslatableSettings($value);
        }


        if(is_array($value)) // هاد بيفحص لو value تعت key كانت عبارة عن array
            //لو كانت array وروحت نفذت امر seed لحتى يعمل push لهاي البيانات في db راح يطلع عندي خطأ اسمه errorexception array to string conversion
            // هاد error يعني انه بقدرش اخزن array في عمود plain_value
            //لانه plain_value نوعه string or text ف ما بينفع نخزن فيه array
            //عشان نحل هاي المشكلة في عندي ميثود اسمها json_encode بتسمحلي او بتخليني اقدر اخزن array في اي عمود سواء كان نوعه string or text
            //يعني هاي الميثود بطبقها على ال value اللي نوعها array لحتى اقدر اخزنها في اي عمود سواء كان نوعه string or text
        {
            $value = json_encode($value);
        }

        static::updateOrCreate(['key' => $key], ['plain_value' => $value]);
    }
    //هاي الجملة static::updateOrCreate يعني اعملي updateOrCreate على المودل اللي انت فيه
    // في حال كان key غير موجود اعمله Create وضيفه هو وقيمته في الجدول اللي عندي
    // اما في حال كان موجود اعمله update


    /**
     * Set a translatable settings.
     *
     * @param array $settings
     * @return void
     */
    public static function setTranslatableSettings($settings = [])
    {
        foreach ($settings as $key => $value) {
            static::updateOrCreate(['key' => $key], [
                'is_translatable' => true,
                'value' => $value,
            ]);
        }
    }


}
