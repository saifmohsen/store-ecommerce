<?php
define('PAGINATION_Count', 30);
function getFolder(){
    return app() -> getLocale() === 'ar' ? 'css-rtl' : 'css';
}
function uploadImage($folder,$image){
    $image->store('/', $folder);
    $filename = $image->hashName();
    return  $filename;
}
