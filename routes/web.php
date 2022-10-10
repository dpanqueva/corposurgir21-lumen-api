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

/**
 * route category
 */
$router->get('/category','CategoryController@index');
$router->get('/category/{category}','CategoryController@show');
$router->post('/category','CategoryController@create');
$router->put('/category/{category}','CategoryController@update');
$router->delete('/category/{category}','CategoryController@delete');

/**
 * route alliance
 */
$router->get('/alliance','AllianceController@index');
$router->get('/alliance/{alliance}','AllianceController@show');
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
$router->get('/company-info/{company}','CompanyInfoController@show');
$router->post('/company-info','CompanyInfoController@create');
$router->put('/company-info/{company}','CompanyInfoController@update');
$router->delete('/company-info/{company}','CompanyInfoController@delete');