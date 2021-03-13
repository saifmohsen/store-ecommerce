<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

    protected $translatedAttributes =["name"]; // هان انا راح اعمل ترجمة بس للاسم فعشان هيك حطيتوا هان
    /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
    protected $fillable = ['parent_id', 'slug', 'is_active'];
     // اي حاجة فيها parent_id مش null تعتبر subcategory
    // اما لو كانت null تعتبر maincategory
    // parent_id refers to maincategory or parent of this category
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['translations']; // هاد column مش موجود عندي ب database لكن بيتم انشاءه وتخزينه في الباكيج نفسها
     // وهان انا عملتله hidden عشان مش كل م اعمل select يروح مرجعلي ياه .. لا انه برجعه وقت مبدي انا وبس
    // طبعا انا بحوله ل visible عشان اقدر استخدمه من خلال method بعملها بال controller
    // او مثلا من خلال هاي الميثود Category -> makevisible('translations')
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];  // ال casting يعني عندي في عمود is_active القيمة اللي متخزنة فيه عبارة عن 0 , 1
    // وانا بدي ارجعها true or flase بدلا من 0 , 1 ف عملتلها casting
// يعني الcasting بيعمل تغيير للنوع
//يعني لما بدي ارجع بيانات واغير نوعها او اغير نوع بيانات من الجدول بستخدم الcasting للاعمدة اللي بدي ياها وبعطيها النوع او الانواع اللي بدي احولها الها

// انا راح اضيف البيانات باستخدام ال factory عشان هو يضيف من عنده وانا اقدر احددلو قديش بدي اضيف


    public function scopeParent($query){
        return $query -> whereNull('parent_id'); ///whereNull equal to where(attriubte, null)
    }
    public function scopeChild($query)
    {
        return $query -> whereNotNull('parent_id'); ///whereNull equal to where(attriubte, null)
    }
    public function getActive(){
        return $this-> is_active == 1 ? 'Active' : 'Not Active';
    }
    public function mainParent(){
        return $this->belongsTo(self::class, 'parent_id');
        // ال self::class معناها الكلاس اللي انا فيه واللي هو Category
        // هاي عملنا relation بين Category و subCategory بحيث انه عن طريق subCategory بقدر اجيب ال maincategory تاعه
    }

}

