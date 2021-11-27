<?php
    require_once __DIR__.'\Router.php';//Router
    require $root.'/api/FreeApiController.php';

    //api functions must to have /Api/ prefix like: http://sup.loc/Api/someFunc
    //prefix regexp is in the .env file

    Route::get("/","FreeApiController@main");
    Route::get("ping","FreeApiController@ping");
    Route::get("/Api/getMenuLinks","FreeApiController@getMenuLinks");
    Route::get("*","FreeApiController@main");
?>