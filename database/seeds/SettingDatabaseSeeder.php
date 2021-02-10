<?php

use App\Models\setting;
use Illuminate\Database\Seeder;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {                       // هلقيت الSeeder بستخدمه عشان اضيف في الداتابيز بطريقة اسرع من اني اضيفها سواء عن طريق tinker او من phpmyadmin
        Setting::setMany([ // طبعا Setting هو اسم المودل المربوط بالجدول اللي بدي اضيف في هاي البيانات
                // ال setMany هاي ميثود انا عملتها في مودل Setting
            //طبعا هاي الميثود بتقبل array بتتكون من key and value
            'default_locale' => 'ar',
            'default_timezone' => 'Asia/Israel',
            'reviews_enabled' => true,
            'auto_approve_reviews' => true,
            'supported_currencies' => ['USD','LE','SAR'], // عبارة عن key وال value تعته عبارة عن array عشان لازم استخدم الها json_encode
            'default_currency' => 'USD',
            'store_email' => 'admin@ecommerce.test',
            'search_engine' => 'mysql',
            'local_shipping_cost' => 0,
            'outer_shipping_cost' => 0,
            'free_shipping_cost' => 0,
            'translatable' => [  // طبعا هاد عبارة عن key انا اعطيته اسم من عندي
                // وهاد ال key بيحتوي على array للبيانات اللي محتاجة ترجمة
                // يعني لازم قيمة is_translatable تكون بتساوي true or 1
                'store_name' => 'متجر الامامي',
                'free_shipping_label' => 'توصيل مجاني',
                'local_label' => 'توصيل داخلي',
                'outer_label' => 'توصيل خارجي',
            ],
        ]);
    }
}
