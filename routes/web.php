<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Rate Limiting Strategy:
| - Public routes: 60 requests/minute (visualización de contenido público)
| - Auth routes: 5 requests/minute (login/logout - prevenir brute force)
| - Write operations (POST/PUT/DELETE): 30 requests/minute
| - Read operations (GET): 100 requests/minute
| - Contact form: 3 requests/minute (prevenir spam)
|
*/

/*
|--------------------------------------------------------------------------
| Authentication Routes (Rate Limit: 5/min - Seguridad Alta)
|--------------------------------------------------------------------------
*/
$router->group(['middleware' => 'throttle:5,1'], function () use ($router) {
    $router->post('/users/login', 'LoginUsersController@login');
    $router->post('/users/logout', 'LoginUsersController@logout');
});

/*
|--------------------------------------------------------------------------
| Public Content Routes (Rate Limit: 60/min - Acceso General)
|--------------------------------------------------------------------------
*/
$router->group(['middleware' => 'throttle:60,1'], function () use ($router) {
    // Category (public read)
    $router->get('/category', 'CategoryController@index');
    $router->get('/category-feature/{category}', 'CategoryController@showDetail');
    
    // Category Feature (public read)
    $router->get('/category-feature', 'CategoryFeatureController@index');
    $router->get('/category-feature-detail/{featureId}', 'CategoryFeatureController@show');
    
    // Alliance (public read)
    $router->get('/alliance', 'AllianceController@index');
    $router->get('/alliance-feature/{name}', 'AllianceController@showDetail');
    
    // Central Image (public read)
    $router->get('/central-image', 'CentralImageController@index');
    $router->get('/central-image/{image}', 'CentralImageController@show');
    
    // Company Info (public read)
    $router->get('/company-info', 'CompanyInfoController@index');
    $router->get('/company-info-feature/{infoCompanyId}', 'CompanyInfoController@showDetail');
    
    // About Info (public read)
    $router->get('/about-info', 'AboutController@index');
    
    // Donation Info (public read)
    $router->get('/donation', 'DonationController@index');
    
    // Social Media (public read)
    $router->get('/social-media', 'SocialMediaController@index');
});

/*
|--------------------------------------------------------------------------
| Contact Form (Rate Limit: 3/min - Anti-Spam)
|--------------------------------------------------------------------------
*/
$router->group(['middleware' => 'throttle:3,1'], function () use ($router) {
    $router->post('/contact', 'ContactsController@create');
});

/*
|--------------------------------------------------------------------------
| User Management (Rate Limit: 10/min - Moderado)
|--------------------------------------------------------------------------
*/
$router->group(['middleware' => 'throttle:10,1'], function () use ($router) {
    $router->get('/users', 'UsersController@index');
    $router->post('/users', 'UsersController@create');
});

/*
|--------------------------------------------------------------------------
| Protected Routes - Authenticated Users
|--------------------------------------------------------------------------
*/
$router->group(['middleware' => 'auth'], function () use ($router) {
    
    /*
    |--------------------------------------------------------------------------
    | Test Route (Rate Limit: 100/min - Alta)
    |--------------------------------------------------------------------------
    */
    $router->group(['middleware' => 'throttle:100,1'], function () use ($router) {
        $router->get('/ruta', function () use ($router) {
            return ["accediste"];
        });
    });
    
    /*
    |--------------------------------------------------------------------------
    | Read Operations (Rate Limit: 100/min - Lectura Intensiva)
    |--------------------------------------------------------------------------
    */
    $router->group(['middleware' => 'throttle:100,1'], function () use ($router) {
        // Category (read)
        $router->get('/category/{category}', 'CategoryController@show');
        
        // About Info (read)
        $router->get('/about-info/{aboutId}', 'AboutController@show');
        
        // Company Info (read)
        $router->get('/company-info/{infoCompanyId}', 'CompanyInfoController@show');
        
        // Social Media (read)
        $router->get('/social-media/{socialMediaId}', 'SocialMediaController@show');
        
        // Alliance (read)
        $router->get('/alliance/{allianceId}', 'AllianceController@show');
        
        // Alliance Detail (read)
        $router->get('/alliance-detail', 'AllianceFeaturesController@index');
        $router->get('/alliance-detail/{allianceId}/{allianceName}', 'AllianceFeaturesController@showAlliancesByIdAndName');
        $router->get('/alliance-detail/{allianceId}', 'AllianceFeaturesController@show');
        
        // Donation (read)
        $router->get('/donation/{donationId}', 'DonationController@show');
        
        // Contact (read)
        $router->get('/contact/{contactId}', 'ContactanosController@show');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Write Operations - Standard (Rate Limit: 30/min - Escritura Moderada)
    |--------------------------------------------------------------------------
    */
    $router->group(['middleware' => 'throttle:30,1'], function () use ($router) {
        // Category (write)
        $router->post('/category', 'CategoryController@create');
        $router->put('/category/{category}', 'CategoryController@update');
        $router->delete('/category/{category}', 'CategoryController@delete');
        
        // Category Feature (write)
        $router->post('/category-feature', 'CategoryFeatureController@create');
        $router->put('/category-feature/{featureId}', 'CategoryFeatureController@update');
        $router->delete('/category-feature/{featureObj}', 'CategoryFeatureController@delete');
        
        // About Info (write)
        $router->post('/about-info', 'AboutController@create');
        $router->put('/about-info/{aboutId}', 'AboutController@update');
        $router->delete('/about-info/{aboutId}', 'AboutController@delete');
        
        // Company Info (write)
        $router->post('/company-info', 'CompanyInfoController@create');
        $router->put('/company-info/{companyId}', 'CompanyInfoController@update');
        $router->delete('/company-info/{companyId}', 'CompanyInfoController@delete');
        
        // Social Media (write)
        $router->post('/social-media', 'SocialMediaController@create');
        $router->put('/social-media/{socialMediaId}', 'SocialMediaController@update');
        $router->delete('/social-media/{socialMediaId}', 'SocialMediaController@delete');
        
        // Donation (write)
        $router->post('/donation', 'DonationController@create');
        $router->put('/donation/{donationId}', 'DonationController@update');
        $router->delete('/donation/{donationId}', 'DonationController@delete');
        
        // Contact (write/delete)
        $router->put('/contact/{contactId}', 'ContactanosController@update');
        $router->delete('/contact/{contactId}', 'ContactanosController@delete');
        
        // Alliance Detail (write)
        $router->post('/alliance-detail', 'AllianceFeaturesController@create');
        $router->put('/alliance-detail/{allianceId}', 'AllianceFeaturesController@update');
        $router->delete('/alliance-detail/{allianceId}', 'AllianceFeaturesController@delete');
        
        // Central Image (write)
        $router->post('/central-image', 'CentralImageController@create');
        $router->put('/central-image/{image}', 'CentralImageController@update');
        $router->delete('/central-image/{image}', 'CentralImageController@delete');
    });
    
    /*
    |--------------------------------------------------------------------------
    | Critical Operations - Images (Rate Limit: 10/min - Recursos Costosos)
    |--------------------------------------------------------------------------
    */
    $router->group(['middleware' => 'throttle:10,1'], function () use ($router) {
        // Alliance (write + image upload)
        $router->post('/alliance', 'AllianceController@create');
        $router->put('/alliance/{allianceId}', 'AllianceController@update');
        $router->post('/alliance/{allianceId}', 'AllianceController@updateImage');
        $router->delete('/alliance/{allianceId}', 'AllianceController@delete');
    });
});