<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin  extends Authenticatable
{
    use Notifiable;
    protected $table = 'admins';
    // هلقيت بدل م استخدم ال   fillable واروح اكتب كل كولمن بستخدم هاي الميثود وبتجيبلي كل الكولمن اللي في الجدول
    protected $guarded=[];
    public $timestamps = true;
    protected $guard = 'admin';
}
