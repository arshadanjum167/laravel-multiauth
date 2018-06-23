<?php
use Illuminate\Http\Request;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('user','UserController@index');
// Route::get('role', [
//     // 'middleware' => 'Role:editor',
//     'uses' => 'UserController@index'
//  ]);

// Route::resource('user','UserController');
// Route::get(
//     'user',[
//     'middleware'=>'Test',
//     'uses'=>'UserController@index'
//     ]);

// Route::get('/user/create','UserController@create');
// Route::post('/user/store','UserController@store');
// Route::get('/user/myfunction','UserController@myfunction');

// Route::get('/registration',function(){
  
//     return view('myform');
// });

// Route::post('/registration','UserController@registration');
    
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::prefix('admin')->group(function () {
Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/login', 'Auth\AdminLoginController@login')->name('adminlogin');
Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');


});

