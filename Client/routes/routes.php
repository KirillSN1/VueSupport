<?php
    require_once __DIR__.'\Router.php';//Router
    require $root.'/api/FreeApiController.php';

    Route::get("/","FreeApiController@main");
    Route::get("ping","FreeApiController@ping");
    Route::get("/Api/getMenuLinks","FreeApiController@getMenuLinks");
    Route::get("*","FreeApiController@main");
?>