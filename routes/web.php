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
Route::get('/admin', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');


Route::prefix('admin')->group(function () {
Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/login', 'Auth\AdminLoginController@login')->name('adminlogin');
Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

//Admin forgot password
Route::get('/password/reset','Admin\ForgorPasswordController@showLinkRequestForm')->name('forgot_password');
Route::post('/password/email','Admin\ForgorPasswordController@sendResetLinkEmail');

//Admin reset password
Route::get('/password/reset/{token}','Admin\ResetPasswordController@showResetForm');
Route::post('/password/reset','Admin\ResetPasswordController@reset');

//Admin change password
Route::get('/changepassword', 'Admin\DefaultController@showChangepasswordForm')->name('admin.showchangepassword');
Route::post('/changepassword', 'Admin\DefaultController@changepassword')->name('admin.changepassword');

//Admin Edit Profile
Route::get('/editprofile', 'Admin\DefaultController@showEditprofileForm')->name('admin.showeditprofile');
Route::post('/editprofile', 'Admin\DefaultController@editprofile')->name('admin.editprofile');

//user
//Route::get('/user', 'Admin\UserController@index')->name('admin.user');
Route::resource('user', 'Admin\UserController',[
  'parameters'=>[
    'user'=>'id',
  ]
]);

});

