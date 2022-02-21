<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CompagneController;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\LcdtAdminController;

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
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::post('/update-text-pos',[LcdtAdminController::class,'updateTextPos'])->name('update-text-pos');
    Route::post('/get-text-pos',[LcdtAdminController::class,'getTextPos'])->name('get-text-pos');
});

Route::post('/api',[ApiController::class,'index'])->middleware('cors')->name('api');

Route::post('/authenticate',[LoginController::class, 'authenticate'])->name('authenticate');
Route::get('/logout',[LoginController::class, 'logout'])->name('logout');
Route::get('/test',[TestController::class, 'test'])->name('test');
Route::post('/auth/login',function () {
    return view('welcome');
})->name('login');


Route::group([

    'middleware' => 'web',
    'namespace'  => 'App\Http\Controllers'
], function () {

    Route::get('/getCustomerStatut',[CompagneController::class, 'getCustomerStatut'])->name('getCustomerStatut');
    Route::get('/getCampagneCategory',[CompagneController::class, 'getCampagneCategory'])->name('getCampagneCategory');
    Route::get('/getTemplates/{id}',[CompagneController::class, 'getTemplates'])->name('getTemplates');
    Route::get('/getTemplates/{id}',[CompagneController::class, 'getTemplates'])->name('getTemplates');
    Route::get('/campagne_id/{id}',[CompagneController::class, 'campagne_id'])->name('campagne_id');
    Route::get('/getCampagny_Cible',[CompagneController::class, 'getCampagny_Cible'])->name('getCampagny_Cible');
    Route::post('/ciblesum',[CompagneController::class, 'ciblesum'])->name('ciblesum');
    Route::post('/sendEmailReminder',[CompagneController::class, 'sendEmailReminder'])->name('sendEmailReminder');
    Route::post('/creatCompagne',[CompagneController::class, 'creatCompagne'])->name('creatCompagne');
    Route::get('/getCampagneCible/{id}',[CompagneController::class, 'getCampagneCible'])->name('getCampagneCible');
    Route::get('/datarequest',[CompagneController::class, 'datarequest'])->name('datarequest');
    Route::get('/getStatusName',[CompagneController::class, 'getStatusName'])->name('getStatusName');
    Route::get('/getCibleByCampagne/{id}',[CompagneController::class, 'getCibleByCampagne'])->name('getCibleByCampagne');
    Route::get('/SubCategory/{id}',[CompagneController::class, 'SubCategory'])->name('SubCategory');
    Route::get('/list',[CompagneController::class, 'list'])->name('list');
    Route::get('/getCompgneCibleSelected/{id}',[CompagneController::class, 'getCompgneCibleSelected'])->name('getCompgneCibleSelected');
    Route::put('contentform/{id}', [CompagneController::class, 'contentform'])->name('contentform');

    Route::put('deleteCompagneCible/', [CompagneController::class, 'deleteCompagneCible'])->name('deleteCompagneCible');
    Route::put('insertCompagneCible/', [CompagneController::class, 'insertCompagneCible'])->name('insertCompagneCible');
    Route::get('/getCourrier',[CompagneController::class, 'getCourrier'])->name('getCourrier');
    Route::get('/getOldCompagne',[CompagneController::class, 'getOldCompagne'])->name('getOldCompagne');
    Route::put('deleteOldCompagne/', [CompagneController::class, 'deleteOldCompagne'])->name('deleteOldCompagne');

    Route::get('/exportCsv/{id}',[CompagneController::class, 'exportCsv'])->name('exportCsv'); 
    Route::post('/downloadPdf',[CompagneController::class, 'downloadPdf'])->name('downloadPdf');

    Route::get('/index',[CompagneController::class, 'index'])->name('index');
    Route::post('/insertdestinataire/{id}',[CompagneController::class, 'insertdestinataire'])->name('insertdestinataire');
    // Route::get('/envoi/{id}',[CompagneController::class, 'envoi'])->name('envoi');
    Route::post('/envoiprogramme/{id}',[CompagneController::class, 'envoiprogramme'])->name('envoiprogramme');
    Route::get('/getCount_cible/{id}',[CompagneController::class, 'getCount_cible'])->name('getCount_cible');
    Route::get('/envoi_lettre/{data}/{data_csv}',[CompagneController::class, 'envoi_lettre'])->name('envoi_lettre');
    Route::post('/createdata/{id}',[CompagneController::class, 'createdata'])->name('createdata');
    Route::get('/getTempname/{id}',[CompagneController::class, 'getTempname'])->name('getTempname');
    Route::get('/getContentImage/{id}',[CompagneController::class, 'getContentImage'])->name('getContentImage');
    Route::get('/imagefield/{id}',[CompagneController::class, 'imagefield'])->name('imagefield');
    Route::get('/lettredata/{id}',[CompagneController::class, 'lettredata'])->name('lettredata');

});

Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');


