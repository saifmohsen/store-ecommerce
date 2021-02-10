<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class settingTranslation extends Model
{
    //protected $fillable = ['value'];
    // لو انا مثلا بلاقي صعوبة اني احدد الشغلات اللي بتكون fillable بروح بكتب هاد الامر اللي تحت وبريح راسي
    protected $guarded =[];
    // وهاد بيحددلي كل الشغلات اللي بتكون fillable
    public $timestamps = false ;
}
