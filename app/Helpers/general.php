<?php
define('PAGINATION_Count', 30);
function getFolder(){
    return app() -> getLocale() === 'ar' ? 'css-rtl' : 'css';
}
