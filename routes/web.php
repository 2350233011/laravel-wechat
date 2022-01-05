<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

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
Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('index');
});
Route::get('/index', function () {
    return view('index');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});

Route::post('/login/dologin', [IndexController::class, 'login']);
Route::post('/login/doregister', [IndexController::class, 'register']);
Route::post('/index/querydata', [IndexController::class, 'querydata']);
Route::post('/index/querychatrecord', [IndexController::class, 'querychatrecord']);
Route::post('/index/insertdata', [IndexController::class, 'insertdata']);
Route::post('/index/delchatrecord', [IndexController::class, 'delchatrecord']);
Route::post('/index/upimg', [IndexController::class, 'upimg']);
Route::post('/index/updatedata', [IndexController::class, 'updatedata']);


