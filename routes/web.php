<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['namespace'=>'App\Api\Controllers'],function ($api){
        $api->post('user/login','AuthController@authenticate');

        $api->group(['middleware' => 'jwt.auth'],function ($api){
            //获取hash总和
            $api->get('getTotal','HashController@getTotal');
            //搜索接口
            $api->post('search','HashController@get');

            $api->get('find/{hash}','HashController@find');

        });

    });
});