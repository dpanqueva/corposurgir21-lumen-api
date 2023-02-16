<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/users','UsersController@index');
$router->post('/users','UsersController@create');

/*
| User login
*/
$router->post('/users/login','LoginUsersController@login');
$router->post('/users/logout','LoginUsersController@logout');

/*
 | auth middleware
 |
 */
$router->group(['middleware'=>'auth'], function() use($router){
    $router->get('/ruta',function() use($router){
        return ["accediste"];
    });

    /*
    * route category
    */
    $router->get('/category/{category}','CategoryController@show');
    $router->post('/category','CategoryController@create');
    $router->put('/category/{category}','CategoryController@update');
    $router->delete('/category/{category}','CategoryController@delete');

    /**
    * route category-feature
    */
    $router->post('/category-feature','CategoryFeatureController@create');
    $router->put('/category-feature/{featureId}','CategoryFeatureController@update');
    $router->delete('/category-feature/{featureObj}','CategoryFeatureController@delete');

    /**
     * route about info
     */
    $router->get('/about-info/{aboutId}','AboutController@show');
    $router->post('/about-info','AboutController@create');    
    $router->put('/about-info/{aboutId}','AboutController@update');
    $router->delete('/about-info/{aboutId}','AboutController@delete');

    /**
     * route company info
     */
    $router->get('/company-info/{infoCompanyId}','CompanyInfoController@show');
    $router->post('/company-info','CompanyInfoController@create');
    $router->put('/company-info/{companyId}','CompanyInfoController@update');
    $router->delete('/company-info/{companyId}','CompanyInfoController@delete');


});



/**
 * route category
 */
$router->get('/category','CategoryController@index');
$router->get('/category-feature/{category}','CategoryController@showDetail');



/**
 * route category-feature
 */
$router->get('/category-feature','CategoryFeatureController@index');
$router->get('/category-feature-detail/{featureId}','CategoryFeatureController@show');


/**
 * route alliance
 */
$router->get('/alliance','AllianceController@index');
$router->get('/alliance/{allianceId}','AllianceController@show');
$router->get('/alliance-feature/{name}','AllianceController@showDetail');

$router->post('/alliance','AllianceController@create');
$router->put('/alliance/{alliance}','AllianceController@update');
$router->delete('/alliance/{alliance}','AllianceController@delete');

/**
 * route alliance detail
 */
$router->get('/alliance-detail','AllianceDetailController@index');
$router->get('/alliance-detail/{alliance}','AllianceDetailController@show');
$router->post('/alliance-detail','AllianceDetailController@create');
$router->put('/alliance-detail/{alliance}','AllianceDetailController@update');
$router->delete('/alliance-detail/{alliance}','AllianceDetailController@delete');

/**
 * route alliance detail
 */
$router->get('/menu','MenuController@index');
$router->get('/menu/{menu}','MenuController@show');
$router->post('/menu','MenuController@create');
$router->put('/menu/{menu}','MenuController@update');
$router->delete('/menu/{menu}','MenuController@delete');

/**
 * route central image
 */
$router->get('/central-image','CentralImageController@index');
$router->get('/central-image/{image}','CentralImageController@show');
$router->post('/central-image','CentralImageController@create');
$router->put('/central-image/{image}','CentralImageController@update');
$router->delete('/central-image/{image}','CentralImageController@delete');

/**
 * route company info
 */
$router->get('/company-info','CompanyInfoController@index');
$router->get('/company-info-feature/{infoCompanyId}','CompanyInfoController@showDetail');


/**
 * route about info
 */
$router->get('/about-info','AboutController@index');
