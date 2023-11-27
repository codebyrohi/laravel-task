<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::get('/clear_cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cache is cleared";
});
Route::get('/', [UserController::class,'index']);
Route::group(array('prefix' => 'user'), function ()
{
    Route::get('/', [UserController::class,'index']);
    Route::post('/store', [UserController::class,'store']);
    Route::get('/load_data', [UserController::class,'load_data']);
    Route::post('/ajaxStore', [UserController::class,'ajaxStore']);
});
