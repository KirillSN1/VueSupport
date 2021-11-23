<?php
    require_once __DIR__.'\Router.php';//Router
    require $_SERVER["DOCUMENT_ROOT"].'/api/FreeApiController.php';

    Route::get("ping","FreeApiController@ping");
    Route::get("/","FreeApiController@main");
?>