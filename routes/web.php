<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CompagneController;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\LcdtAdminController;
use App\Http\Controllers\LcdtFrontController;
use App\Http\Controllers\PageElementsController;

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

Route::post('save-page-elements', [PageElementsController::class, 'store']);
Route::get('get-page-order/{order}', [PageElementsController::class, 'get_page_order']);

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

    Route::get('/getCustomerStatut',[CompagneController::class, 'getCustomerStatut'])->middleware('auth')->name('getCustomerStatut');
    Route::get('/getCampagneCategory',[CompagneController::class, 'getCampagneCategory'])->middleware('auth')->name('getCampagneCategory');
    Route::get('/getTemplates/{id}',[CompagneController::class, 'getTemplates'])->middleware('auth')->name('getTemplates');
    Route::get('/campagne_id/{id}',[CompagneController::class, 'campagne_id'])->middleware('auth')->name('campagne_id');
    Route::get('/getCampagny_Cible',[CompagneController::class, 'getCampagny_Cible'])->middleware('auth')->name('getCampagny_Cible');
    Route::post('/ciblesum',[CompagneController::class, 'ciblesum'])->middleware('auth')->name('ciblesum');
    Route::post('/sendEmailReminder',[CompagneController::class, 'sendEmailReminder'])->middleware('auth')->name('sendEmailReminder');
    Route::post('/creatCompagne',[CompagneController::class, 'creatCompagne'])->middleware('auth')->name('creatCompagne');
    Route::get('/getCampagneCible/{id}',[CompagneController::class, 'getCampagneCible'])->middleware('auth')->name('getCampagneCible');
    Route::get('/datarequest',[CompagneController::class, 'datarequest'])->middleware('auth')->name('datarequest');
    Route::get('/getStatusName',[CompagneController::class, 'getStatusName'])->middleware('auth')->name('getStatusName');
    Route::get('/getCibleByCampagne/{id}',[CompagneController::class, 'getCibleByCampagne'])->middleware('auth')->name('getCibleByCampagne');
    Route::get('/SubCategory/{id}',[CompagneController::class, 'SubCategory'])->middleware('auth')->name('SubCategory');
    Route::get('/list',[CompagneController::class, 'list'])->middleware('auth')->name('list');
    Route::get('/getCompgneCibleSelected/{id}',[CompagneController::class, 'getCompgneCibleSelected'])->middleware('auth')->name('getCompgneCibleSelected');
    Route::put('contentform/{id}', [CompagneController::class, 'contentform'])->middleware('auth')->name('contentform');

    Route::put('deleteCompagneCible/', [CompagneController::class, 'deleteCompagneCible'])->middleware('auth')->name('deleteCompagneCible');
    Route::put('insertCompagneCible/', [CompagneController::class, 'insertCompagneCible'])->middleware('auth')->name('insertCompagneCible');
    Route::get('/getCourrier',[CompagneController::class, 'getCourrier'])->middleware('auth')->name('getCourrier');
    Route::get('/getOldCompagne',[CompagneController::class, 'getOldCompagne'])->middleware('auth')->name('getOldCompagne');
    Route::put('deleteOldCompagne/', [CompagneController::class, 'deleteOldCompagne'])->middleware('auth')->name('deleteOldCompagne');

    Route::get('/exportCsv/{id}',[CompagneController::class, 'exportCsv'])->middleware('auth')->name('exportCsv');
    Route::post('/downloadPdf',[CompagneController::class, 'downloadPdf'])->middleware('auth')->name('downloadPdf');

    Route::get('/index',[CompagneController::class, 'index'])->middleware('auth')->name('index');
    Route::post('/insertdestinataire/{id}',[CompagneController::class, 'insertdestinataire'])->middleware('auth')->name('insertdestinataire');
    // Route::get('/envoi/{id}',[CompagneController::class, 'envoi'])->name('envoi');
    Route::post('/envoiprogramme/{id}',[CompagneController::class, 'envoiprogramme'])->middleware('auth')->name('envoiprogramme');
    Route::get('/getCount_cible/{id}',[CompagneController::class, 'getCount_cible'])->middleware('auth')->name('getCount_cible');
    Route::get('/envoi_lettre/{data}/{data_csv}',[CompagneController::class, 'envoi_lettre'])->middleware('auth')->name('envoi_lettre');
    Route::post('/createdata/{id}',[CompagneController::class, 'createdata'])->middleware('auth')->name('createdata');
    Route::get('/getTempname/{id}',[CompagneController::class, 'getTempname'])->middleware('auth')->name('getTempname');
    Route::get('/getContentImage/{id}',[CompagneController::class, 'getContentImage'])->middleware('auth')->name('getContentImage');
    Route::get('/imagefield/{id}',[CompagneController::class, 'imagefield'])->middleware('auth')->name('imagefield');
    Route::get('/lettredata/{id}',[CompagneController::class, 'lettredata'])->middleware('auth')->name('lettredata');
    Route::post('/get-affiliate-detail',[LcdtFrontController::class,'getAffiliateDetail'])->middleware('auth')->name('get-affiliate-detail');
    Route::post('/get-campagne-details',[LcdtFrontController::class, 'getCampagneCategory'])->middleware('auth')->name('get-campagne-details');
    Route::post('/get-cible-emails',[LcdtFrontController::class,'getCibleEmails'])->middleware('auth')->name('get-cible-emails');
});

Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');


