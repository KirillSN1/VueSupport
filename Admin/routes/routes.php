<?php
    require_once __DIR__.'\Router.php';//Router
    require $root.'/api/ApiController.php';
    
    Route::post("/Api/checkProfile","ApiController@checkProfile");
    if(!AuthorizationController::load_profile()){
        require "./php/app/authorizationPage.php";
        exit;
    }

    Route::get("/","ApiController@main");
    Route::get("/logout","ApiController@logout");
    Route::get("/Api/ping","ApiController@ping");
    Route::get("/Api/getProfile", "ApiController@getProfile");
    Route::get("/Api/getArticles", "ApiController@getArticles");
    Route::get("*","ApiController@main");
?>