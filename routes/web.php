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
$router->get('/users', 'UsersController@index');
$router->post('/users', 'UsersController@create');

/*
| User login
*/
$router->post('/users/login', 'LoginUsersController@login');
$router->post('/users/logout', 'LoginUsersController@logout');

/*
 | auth middleware
 |
 */
$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/ruta', function () use ($router) {
        return ["accediste"];
    });

    /*
    * route category
    */
    $router->get('/category/{category}', 'CategoryController@show');
    $router->post('/category', 'CategoryController@create');
    $router->put('/category/{category}', 'CategoryController@update');
    $router->delete('/category/{category}', 'CategoryController@delete');

    /**
     * route category-feature
     */
    $router->post('/category-feature', 'CategoryFeatureController@create');
    $router->put('/category-feature/{featureId}', 'CategoryFeatureController@update');
    $router->delete('/category-feature/{featureObj}', 'CategoryFeatureController@delete');

    /**
     * route about info
     */
    $router->get('/about-info/{aboutId}', 'AboutController@show');
    $router->post('/about-info', 'AboutController@create');
    $router->put('/about-info/{aboutId}', 'AboutController@update');
    $router->delete('/about-info/{aboutId}', 'AboutController@delete');

    /**
     * route company info
     */
    $router->get('/company-info/{infoCompanyId}', 'CompanyInfoController@show');
    $router->post('/company-info', 'CompanyInfoController@create');
    $router->put('/company-info/{companyId}', 'CompanyInfoController@update');
    $router->delete('/company-info/{companyId}', 'CompanyInfoController@delete');

    /**
     * route company social media
     */
    $router->get('/social-media', 'SocialMediaController@index');
    $router->get('/social-media/{socialMediaId}', 'SocialMediaController@show');
    $router->post('/social-media', 'SocialMediaController@create');
    $router->put('/social-media/{socialMediaId}', 'SocialMediaController@update');
    $router->delete('/social-media/{socialMediaId}', 'SocialMediaController@delete');

    /**
     * route alliance
     */
    $router->get('/alliance/{allianceId}', 'AllianceController@show');
    $router->post('/alliance', 'AllianceController@create');
    $router->put('/alliance/{allianceId}', 'AllianceController@update');
    $router->post('/alliance/{allianceId}', 'AllianceController@updateImage');
    $router->delete('/alliance/{allianceId}', 'AllianceController@delete');

    /**
     * route alliance detail
     */
    $router->get('/alliance-detail', 'AllianceFeaturesController@index');
    $router->get('/alliance-detail/{allianceId}/{allianceName}', 'AllianceFeaturesController@showAlliancesByIdAndName');
    $router->get('/alliance-detail/{allianceId}', 'AllianceFeaturesController@show');
    $router->post('/alliance-detail', 'AllianceFeaturesController@create');
    $router->put('/alliance-detail/{allianceId}', 'AllianceFeaturesController@update');
    $router->delete('/alliance-detail/{allianceId}', 'AllianceFeaturesController@delete');

    /**
     * route donation info
     */
    $router->get('/donation/{donationId}', 'DonationController@show');
    $router->post('/donation', 'DonationController@create');
    $router->put('/donation/{donationId}', 'DonationController@update');
    $router->delete('/donation/{donationId}', 'DonationController@delete');

    /**
     * route contact
     */
    $router->get('/contact/{contactId}', 'ContactanosController@show');
    $router->put('/contact/{contactId}', 'ContactanosController@update');
    $router->delete('/contact/{contactId}', 'ContactanosController@delete');
});

/**
 * route category
 */
$router->get('/category', 'CategoryController@index');
$router->get('/category-feature/{category}', 'CategoryController@showDetail');

/**
 * route category-feature
 */
$router->get('/category-feature', 'CategoryFeatureController@index');
$router->get('/category-feature-detail/{featureId}', 'CategoryFeatureController@show');

/**
 * route alliance
 */
$router->get('/alliance', 'AllianceController@index');
$router->get('/alliance-feature/{name}', 'AllianceController@showDetail');

/**
 * route central image
 */
$router->get('/central-image', 'CentralImageController@index');
$router->get('/central-image/{image}', 'CentralImageController@show');
$router->post('/central-image', 'CentralImageController@create');
$router->put('/central-image/{image}', 'CentralImageController@update');
$router->delete('/central-image/{image}', 'CentralImageController@delete');

/**
 * route company info
 */
$router->get('/company-info', 'CompanyInfoController@index');
$router->get('/company-info-feature/{infoCompanyId}', 'CompanyInfoController@showDetail');

/**
 * route about info
 */
$router->get('/about-info', 'AboutController@index');

/**
 * route donation info
 */
$router->get('/donation', 'DonationController@index');

/**
 * route contact
 */
$router->post('/contact', 'ContactsController@create');
