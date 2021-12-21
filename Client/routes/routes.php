<?php
    require_once __DIR__.'\Router.php';//Router
    require $root.'/api/FreeApiController.php';

    Route::get("/","FreeApiController@main");
    Route::get("/Api/ping","FreeApiController@ping");
    Route::get("/Api/getMenuLinks","FreeApiController@getMenuLinks");
    Route::get("/Api/getAboutGroups","FreeApiController@getAboutGroups");
    Route::get("/Api/getItemsGroups","FreeApiController@getItemsGroups");
    Route::get("/Api/getFooterGroups","FreeApiController@getFooterGroups");
    Route::get("/Api/getArticlesTitles","FreeApiController@getArticlesTitles");
    Route::get("/articledoc","FreeApiController@getArticle");
    Route::get("*","FreeApiController@main");
?>