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

Auth::routes();

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index')->name('home');

// Routing backend administrator
$router->group([
    'namespace'  => 'Backend',
    'prefix'     => config('larakuy.prefix_admin', 'backend'), 
    'as'         => 'backend::',
    'middleware' => 'auth'
    ], function ($router) {
        
    
    // Dashboard
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/kirimEmail','EmailController@index')->name('kirimEmail');
    // Route::get('/permitsControl', 'HomeController@permitsControl')->name('permitsControl');
    // Route::get('/mouControl', 'HomeController@mouControl')->name('mouControl');
    // Route::get('/tambahTruck', 'TruckPermitsController@tambahTruck')->name('tambahTruck');
    // Route::get('/listTruck', 'TruckPermitsController@index')->name('listTruck');
    // Route::get('/dataTruck', 'TruckPermitsController@dataTruck')->name('dataTruck');

    //manifest
    Route::get('/manifestControl', 'ManifestControlController@index')->name('manifestControl');
    Route::get('/manifestControl/{id}/edit', 'ManifestControlController@edit')->name('manifestControl_edit');
    Route::patch('/manifestControl/{id}/edit', 'ManifestControlController@update')->name('manifestControl_update');
    Route::delete('/manifestControl/{id}/delete', 'ManifestControlController@delete')->name('manifestControl_delete');
    
    //mou Control
    Route::get('/mouControl', 'MouControlController@index')->name('mouControl');
    Route::get('/mouControl/tambah', 'MouControlController@add')->name('mouControl_add');
    Route::post('/mouControl/', 'MouControlController@save')->name('mouControl_save');
    Route::get('/mouControl/{id}/edit', 'MouControlController@edit')->name('mouControl_edit');
    Route::patch('/mouControl/{id}/edit', 'MouControlController@update')->name('mouControl_update');
    Route::delete('/mouControl/{id}/delete', 'MouControlController@delete')->name('mouControl_delete');
    Route::get('/mouControl/download/{lampiran}/{id}/', 'MouControlController@download')->name('mouControl_download');
    Route::get('/mouControl/downloads/{id}/', 'MouControlController@downloads')->name('mouControl_downloads');
    
    //Truck Control
    Route::get('/truckPermits', 'TruckPermitsController@index')->name('truckPermits');
    Route::get('/truckPermits/tambah', 'TruckPermitsController@add')->name('truckPermits_add');
    Route::post('/truckPermits/', 'TruckPermitsController@save')->name('truckPermits_save');
    Route::get('/truckPermits/{id}/edit', 'TruckPermitsController@edit')->name('truckPermits_edit');
    Route::patch('/truckPermits/{id}/edit', 'TruckPermitsController@update')->name('truckPermits_update');
    Route::delete('/truckPermits/{id}/delete', 'TruckPermitsController@delete')->name('truckPermits_delete');
    Route::get('/truckPermits/download/{lampiran}/{id}/', 'TruckPermitsController@download')->name('truckPermits_download');
    Route::get('/truckPermits/downloads/{id}/', 'TruckPermitsController@downloads')->name('truckPermits_downloads');
    //permits Control
    Route::get('/permitsControl', 'PermitsControlController@index')->name('permitsControl');
    Route::get('/permitsControl/tambah', 'PermitsControlController@add')->name('permitsControl_add');
    Route::post('/permitsControl/', 'PermitsControlController@save')->name('permitsControl_save');
    Route::get('/permitsControl/{id}/edit', 'PermitsControlController@edit')->name('permitsControl_edit');
    Route::patch('/permitsControl/{id}/edit', 'PermitsControlController@update')->name('permitsControl_update');
    Route::delete('/permitsControl/{id}/delete', 'PermitsControlController@delete')->name('permitsControl_delete');
    Route::get('/permitsControl/download/{id}/', 'PermitsControlController@download')->name('permitsControl_download');
    //penyimpanan
    Route::get('/penyimpananLimbahB3', 'PenyimpananLimbahB3Controller@index')->name('penyimpananLimbahB3');
    Route::get('/penyimpananLimbahB3/tambah', 'PenyimpananLimbahB3Controller@add')->name('penyimpananLimbahB3_add');
    Route::post('/penyimpananLimbahB3/', 'PenyimpananLimbahB3Controller@save')->name('penyimpananLimbahB3_save');
    Route::get('/penyimpananLimbahB3/{id}/edit', 'PenyimpananLimbahB3Controller@edit')->name('penyimpananLimbahB3_edit');
    Route::patch('/penyimpananLimbahB3/{id}/edit', 'PenyimpananLimbahB3Controller@update')->name('penyimpananLimbahB3_update');
    Route::delete('/penyimpananLimbahB3/{id}/delete', 'PenyimpananLimbahB3Controller@delete')->name('penyimpananLimbahB3_delete');
    Route::get('/penyimpananLimbahB3/logbook/', 'PenyimpananLimbahB3Controller@logbookDownload')->name('penyimpananLimbahB3_logbook');
    //pengangkutan
    Route::get('/pengangkutanLimbahB3', 'PengangkutanLimbahB3Controller@index')->name('pengangkutanLimbahB3');
    Route::get('/pengangkutanLimbahB3/tambah', 'PengangkutanLimbahB3Controller@add')->name('pengangkutanLimbahB3_add');
    Route::post('/pengangkutanLimbahB3/', 'PengangkutanLimbahB3Controller@save')->name('pengangkutanLimbahB3_save');
    Route::get('/pengangkutanLimbahB3/{id}/edit', 'PengangkutanLimbahB3Controller@edit')->name('pengangkutanLimbahB3_edit');
    Route::patch('/pengangkutanLimbahB3/{id}/edit', 'PengangkutanLimbahB3Controller@update')->name('pengangkutanLimbahB3_update');
    Route::delete('/pengangkutanLimbahB3/{id}/delete', 'PengangkutanLimbahB3Controller@delete')->name('pengangkutanLimbahB3_delete');
    Route::get('/pengangkutanLimbahB3/logbook/', 'PengangkutanLimbahB3Controller@logbookDownload')->name('pengangkutanLimbahB3_logbook');
});
