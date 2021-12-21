<?php
    require_once __DIR__.'\Router.php';//Router
    require $root.'/api/ApiController.php';
    require $root.'/api/ArticlesController.php';
    
    Route::post("/Api/checkProfile","ApiController@checkProfile");
    if(!AuthorizationController::load_profile()){
        require "./php/app/authorizationPage.php";
        exit;
    }

    Route::get("/","ApiController@main");
    Route::get("/Api/ping","ApiController@ping");
    
    //authorization
    Route::get("/logout","ApiController@logout");
    Route::get("/Api/getProfile", "ApiController@getProfile");
    //groups
    Route::get("/Api/getItemsGroups","ApiController@getItemsGroups");
    //about
    Route::get("/Api/getAboutGroups","ApiController@getAboutGroups");
    //articles
    Route::get("/Api/getArticles", "ArticlesController@getArticles");
    Route::get("/article", "ArticlesController@article");
    Route::get("/Api/getArticle", "ArticlesController@getArticle");
    Route::post("/Api/saveArticle", "ArticlesController@saveArticle");
    Route::post("/Api/saveArticleImage", "ArticlesController@saveArticleImage");
    Route::get("/Api/linkArticle","ApiController@linkArticle");
    Route::get("/Api/unlinkArticle","ApiController@unlinkArticle");
    //end
    Route::get("*","ApiController@main");
?>