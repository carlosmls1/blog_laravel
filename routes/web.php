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

use App\Http\Resources\UserCollection;
use HttpOz\Roles\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user', 'UserController@index')->name('user');
Route::group(['middleware' => ['auth']], function() {
    Route::patch('/update', 'UsersController@profile')->name('user.profile');

    Route::group(['prefix' => 'resources'], function () {
        Route::get('/users/{role}', function (\Illuminate\Http\Request $request, $role) {
            $adminRole = Role::findBySlug($role);
            $admins = $adminRole->users;
            if ($request->has('q') && $request->q != '') {
                $search = $request->q;
                $admins = $admins->filter(function($item) use ($search) {
                    return stripos($item['email'],$search) !== false;
                });
            }
            return new UserCollection($admins);
        });
    });


    Route::group(['prefix' => 'users', 'middleware' => 'role:admin|supervisor', 'namespace' => 'Users'], function() {
        Route::get('/', 'UsersController@users')->name('user.supervisor');

        Route::group(['prefix' => 'user','middleware' => 'role:admin'], function () {
            Route::get('/', 'UsersController@index')->name('user.index');
            Route::get('/create', 'UsersController@create')->name('user.create');
            Route::post('/create', 'UsersController@store')->name('user.store');
            Route::get('/{user}/show', 'UsersController@show')->name('user.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('user.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('user.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('user.destroy');
        });



    });

    Route::group(['prefix' => 'posts'], function() {
        Route::get('/', 'PostsController@index')->name('posts.index');
        Route::get('/create', 'PostsController@create')->name('posts.create');
        Route::post('/create', 'PostsController@store')->name('posts.store');
        Route::get('/{post}/show', 'PostsController@show')->name('posts.show');
        Route::get('/{post}/edit', 'PostsController@edit')->name('posts.edit');
        Route::patch('/{post}/update', 'PostsController@update')->name('posts.update');
        Route::delete('/{post}/delete', 'PostsController@destroy')->name('posts.destroy');
    });
});
