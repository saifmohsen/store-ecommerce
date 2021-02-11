<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingsRequest;
use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SettingController extends Controller
{
    public function shippingMethods($type){
        //free , inner , outer for shipping methods

        if ($type === 'free')
             $shippingMethod = Setting::where('key', 'free_shipping_label')->first();


        elseif ($type === 'inner')
            $shippingMethod = Setting::where('key', 'local_label')->first();

        elseif ($type === 'outer')
            $shippingMethod = Setting::where('key', 'outer_label')->first();
        else
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();


        return view('admin.settings.shippings.shipping', compact('shippingMethod'));

    }
                public function UpdateShippingMethods(ShippingsRequest $request, $id){
                    try {
                        DB::beginTransaction(); // هاي الميثود لازم والافضل اني استخدمها لما يكون عندي اكتر من جملة استعلام للداتا بيز
                        //يعني مثلا كان عندي جملة بتعمل update وجملة بتعمل insert في نفس الفنكشن فلازم استخدم هاي الميثود
                        //طبعا بستخدمها عشان اضمن انه ينفذ الجملتين وانه لو صار خطأ في وحدة مينفذش التانية
                        // يعني هان عندي جملتين update فلو حدث خطأ في وحدة مش راح ينف1 التانية
                        // يعني لازم الجملتين يتم تنفيذهم غير هيك راح يطلع عندي ايرور
                        // يعني باختصار ال Transaction بتخلي الداتبيز تعرف انه كل جمل الاستعلام اللي هان هي جزء من Transaction
                       //واي استعلام بيحدث في خطأ مش راح ينفذ الباقي
                        // ولو صار عندي اي خطأ في اي استعلام راح يروح على catch وينفذ جملة rollBack
                        // اما لو مفش اي خطأ في جمل الاستعلام راح ينفذ جملة commit
                        // طبعا استخدمنا try و catch عشان عندي اكتر من جملة استعلام
                        $shipping_method = setting::find($id);  //لو لقيت هاد ال id في جدول setting رجعلي بياناته وخزنها في هاد المتغير
                        $shipping_method ->update(['plain_value' => $request -> plain_value]);
                        // هلقيت انا في الفورم اللي عندي بس بقدر اغير ال plain_value و value
                        //وطبعا ما حطيت value في جملة update اللي فوق لانه اللي فوق راح يتعامل بس مع جدول setting
                        // لكن بم انه هاي الباكيج بتعملي علاقة بين الجدول وترجمته فراح اقدر اصل لاي عمود في جدول الترجمة
                        // عشان هيك بعمل update لل value حارج جملة ال update
                        $shipping_method -> value = $request -> value ;
                        $shipping_method -> save();
                        //$shipping_method -> save(); => this save translations that exist in translation table
                        DB::commit(); // هاد الامرعشان ينفذ transaction اللي فوق
                        // يعني لو ما عملناه مش راح ينفذ جمل الاستعلام لانه هو بينفذ امر transaction
                        return redirect()->back()->with(['success' => 'saved successfully']);
                    }catch (\Exception $exception){
                        return redirect()->back()->with(['errors' => 'there is a problem, please try again later']);
                        DB::rollBack(); // هاد عشان يلغي عملية ارسال الاستعلام للداتبيز لو صار عندي اي خطأ
                            // او هو بيلغي Transaction كلها
                    }

                }



}
