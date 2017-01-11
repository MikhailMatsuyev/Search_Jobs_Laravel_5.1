<?php


App::setLocale(env('LOCALE', 'en'));




get('/', 'HomeController@index');
get('/rss.xml', 'HomeController@rss');
get('/sitemap.xml', 'HomeController@sitemap');
get('/login', 'AuthController@getLogin');
get('/register', 'AuthController@getRegister');
get('/logout', 'AuthController@getLogout');
post('/login', 'AuthController@postLogin');
get('/jobs', 'HomeController@jobList');
get('/category/{id}', 'HomeController@categoryFilter');
get('/subcategory/{id}', 'HomeController@subcategoryFilter');
get('/country/{country_name}', 'HomeController@countryFilter');
post('/jobs', 'HomeController@searchJobList');
post('/job_apply/{id}', 'HomeController@jobApply');
post('/upload_resume/{id}', 'HomeController@uploadResume');
get('/price_filter/{id}', 'HomeController@priceFilter');
get('/company/{id}', 'HomeController@companyFilter');
get('/state/{id}', 'HomeController@stateFilter');
get('/city/{id}', 'HomeController@cityFilter');
get('/keyword/{id}', 'HomeController@keywordFilter');
post('/reset_password', 'AuthController@postReset');
get('/reset_password/{email}/{reset_code}', 'AuthController@getReset');
post('/forgot_password', 'AuthController@getForgotPassword');
get('/forgot-password', 'AuthController@getForgotPassword');
post('/forgot-password', 'AuthController@postForgotPassword');
Route::get('/register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'HomeController@confirm'
]);

post('/register', 'HomeController@registerCustomer');


Route::get('/contact',  'HomeController@getContact');

Route::post('/contact',  'HomeController@contact');



//Error Handler
get('/403', 'HomeController@show403');
get('/404', 'HomeController@show404');
get('/500', 'HomeController@show500');
get('/503', 'HomeController@show503');

//Site Routes
get('/page/{page_slug}', 'HomeController@page');
get('/author/{author_slug}', 'HomeController@byAuthor');
get('/category/{category_slug}', 'HomeController@byCategory');
get('/category/{category_slug}/{sub_category_slug}', 'HomeController@bySubCategory');
get('/tag/{tag_slug}', 'HomeController@byTag');
get('/api/keywords/', 'APIController@getKeywords');
get('/api/countries', 'APIController@getCountries');
get('/api/states/', 'APIController@getStates');
get('/api/city/', 'APIController@getCity');
get('/search', 'HomeController@bySearch');
get('/rss.xml', 'HomeController@rss');
get('/rss/{category_slug}', 'HomeController@categoryRss');
get('/rss/{category_slug}/{sub_category_slug}', 'HomeController@subCategoryRss');
get('/sitemap.xml', 'HomeController@sitemap');

post('/submit_rating', 'HomeController@submitRating');
post('/submit_likes', 'HomeController@submitLike');

Route::group(array('namespace' => 'Customer', 'prefix' => 'customer', 'middleware' => 'customer_auth'), function () {

    get('/', 'PostsController@listJobs');
    post('/{id}', 'PostsController@stripe');
    get('/job_post', 'PostsController@jobPost');
    post('/posts/create', 'PostsController@store');
    get('/change_password', 'PostsController@changePassword');
    post('/change_password', 'PostsController@updatePassword');
    get('/applicants', 'PostsController@getApplicants');





});

//Admin Routes
Route::group(array('namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'admin_auth'), function () {

    get('/', 'DashboardController@index');

    get('/update_application', 'DashboardController@updateApplication');

    get('/give-me-write-access', 'DashboardController@giveMeWriteAccess');
    get('/remove-write-access', 'DashboardController@removeWriteAccess');




    Route::group(array('prefix' => 'crons'), function () {

        get('/', 'CronController@all');
        get('/all', 'CronController@all');
        get('/run', 'CronController@run');

        get('/view/{id}', 'CronController@view')->where(array('id' => '[0-9]+'));
        get('/delete/{id}', 'CronController@delete')->where(array('id' => '[0-9]+'));;

    });

    Route::group(array('prefix' => 'roles'), function () {

        get('/', 'UserRolesController@all');
        get('/all', 'UserRolesController@all');

        get('/create', 'UserRolesController@create');
        get('/edit/{id}', 'UserRolesController@edit')->where(array('id' => '[0-9]+'));
        get('/delete/{id}', 'UserRolesController@delete')->where(array('id' => '[0-9]+'));;

        post('/create', 'UserRolesController@store');
        post('/update', 'UserRolesController@update');

    });


    Route::group(array('prefix' => 'users'), function () {

        get('/', 'UsersController@all');
        get('/all', 'UsersController@all');

        get('/create', 'UsersController@create');
        get('/edit/{id}', 'UsersController@edit')->where(array('id' => '[0-9]+'));
        get('/delete/{id}', 'UsersController@delete')->where(array('id' => '[0-9]+'));;

        post('/create', 'UsersController@store');
        post('/update', 'UsersController@update');

    });

    Route::group(array('prefix' => 'categories'), function () {

        get('/', 'CategoryController@all');
        get('/all', 'CategoryController@all');

        get('/create', 'CategoryController@create');
        get('/edit/{id}', 'CategoryController@edit')->where(array('id' => '[0-9]+'));;
        get('/delete/{id}', 'CategoryController@delete')->where(array('id' => '[0-9]+'));;

        post('/create', 'CategoryController@store');
        post('/update', 'CategoryController@update');

    });

    Route::group(array('prefix' => 'sub_categories'), function () {

        get('/', 'SubCategoryController@all');
        get('/all', 'SubCategoryController@all');

        get('/create', 'SubCategoryController@create');
        get('/edit/{id}', 'SubCategoryController@edit')->where(array('id' => '[0-9]+'));;
        get('/delete/{id}', 'SubCategoryController@delete')->where(array('id' => '[0-9]+'));;

        post('/create', 'SubCategoryController@store');
        post('/update', 'SubCategoryController@update');

    });

    Route::group(array('prefix' => 'sources'), function () {

        get('/', 'SourcesController@all');
        get('/all', 'SourcesController@all');
        get('/pull_feeds', 'SourcesController@pullFeeds');
        get('/pull_page', 'SourcesController@pullPages');

        get('/create', 'SourcesController@create');
        get('/edit/{id}', 'SourcesController@edit')->where(array('id' => '[0-9]+'));;
        get('/delete/{id}', 'SourcesController@delete')->where(array('id' => '[0-9]+'));;

        post('/create', 'SourcesController@store');
        post('/update', 'SourcesController@update');

    });

    Route::group(array('prefix' => 'posts'), function () {

        get('/', 'PostsController@all');
        get('/all', 'PostsController@all');

        get('/create', 'PostsController@create');
        get('/edit/{id}', 'PostsController@edit')->where(array('id' => '[0-9]+'));
        get('/delete/{id}', 'PostsController@delete')->where(array('id' => '[0-9]+'));

        //dump();

        post('/create', 'PostsController@store');
        post('/update', 'PostsController@update');

    });

    Route::group(array('prefix' => 'ratings'), function () {
        get('/', 'RatingsController@all');
        get('/all', 'RatingsController@all');
        get('/delete/{id}', 'RatingsController@delete')->where(array('id' => '[0-9]+'));
    });

    Route::group(array('prefix' => 'tags'), function () {
        get('/', 'TagsController@all');
        get('/all', 'TagsController@all');
        get('/delete/{id}', 'TagsController@delete')->where(array('id' => '[0-9]+'));
    });

    Route::group(array('prefix' => 'pages'), function () {

        get('/', 'PagesController@all');
        get('/all', 'PagesController@all');

        get('/create', 'PagesController@create');
        get('/edit/{id}', 'PagesController@edit')->where(array('id' => '[0-9]+'));
        get('/delete/{id}', 'PagesController@delete')->where(array('id' => '[0-9]+'));

        post('/create', 'PagesController@store');
        post('/update', 'PagesController@update');

    });

    Route::group(array('prefix' => 'ads'), function () {

        get('/', 'AdsController@all');
        get('/all', 'AdsController@all');

        get('/create', 'AdsController@create');
        get('/edit/{id}', 'AdsController@edit')->where(array('id' => '[0-9]+'));;
        get('/delete/{id}', 'AdsController@delete')->where(array('id' => '[0-9]+'));;

        post('/create', 'AdsController@store');
        post('/update', 'AdsController@update');

    });

    Route::group(array('prefix' => 'statistics'), function () {

        get('/', 'StatisticsController@all');
        get('/all', 'StatisticsController@all');


    });

    Route::group(array('prefix' => 'settings'), function () {

        get('/', 'SettingsController@all');
        get('/all', 'SettingsController@all');

        post('update_custom_css', 'SettingsController@updateCustomCSS');
        post('update_custom_js', 'SettingsController@updateCustomJS');
        post('update_social', 'SettingsController@updateSocial');
        post('update_comments', 'SettingsController@updateComments');
        post('update_seo', 'SettingsController@updateSEO');
        post('update_general', 'SettingsController@updateGeneral');

    });

    Route::get('/redactor/images.json', 'DashboardController@redactorImages');


});

Route::group(array('middleware' => 'auth'), function () {
    Route::group(array('prefix' => 'api'), function () {
        get('/get_sub_categories_by_category/{id}', 'APIController@getSubCategories');
        get('/get_tags', 'APIController@getTags');
        get('/get_cities/{id}', 'APIController@getCities');
        get('/get_states/{id}', 'APIController@getAdminStates');
    });
    Route::post('redactor', 'DashboardController@handleRedactorUploads');
});

//should be last route
get('/{id}', 'HomeController@jobDetails');
