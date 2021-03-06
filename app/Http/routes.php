<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group([ 'prefix' => 'auth' ], function () {
    /*
     * Authentication
     */
    require 'routes/auth.php';
});

// Password reset link request routes
Route::get('password/email', [
    'as'   => 'password.create',
    'uses' => 'Auth\PasswordController@getEmail'
]);

Route::post('password/email', [
    'as'   => 'password.store',
    'uses' => 'Auth\PasswordController@postEmail'
]);

// Password reset routes
Route::get('password/reset/{token}', [
    'as'   => 'reset.create',
    'uses' => 'Auth\PasswordController@getReset'
]);

Route::post('password/reset', [
    'as'   => 'reset.store',
    'uses' => 'Auth\PasswordController@postReset'
]);

Route::group([ 'middleware' => 'auth' ], function () {
    Route::group([ 'middleware' => 'is_admin' ], function () {
        /*
         * Home
         */
        Route::get('/', function () {
            return redirect()->route('home');
        });

        Route::get('home', [
            'as'   => 'home',
            'uses' => 'HomeController@index'
        ]);

        /*
         * Header DE
         */
        require 'routes/de.issuance.php';

        require 'routes/de.client.php';

        require 'routes/de.question.php';

        require 'routes/certificate.php';

        require 'routes/report.php';

        require 'routes/pdfSleep.php';

        /*
         * Header TD
         */
        require 'routes/td.issuance.php';
        /*
         * Header AU
         */
        require 'routes/au.issuance.php';

    });

    /*
     * Administrator
     */
    Route::group([ 'middleware' => 'is_user' ], function () {
        require 'routes/admin.php';
    });
});

Route::get('{rp_id}/facultative/{id}/mc/show', [
    'as'   => 'de.fa.mc.show',
    'uses' => 'De\MedicalCertificateController@show'
]);

/*RUTA UNICA PRODUCTOS MODAL*/
Route::get('certificate/{id_retailer_product}/{id_header}/{text}/{type}', [
    'as'   => 'create_modal_slip',
    'uses' => 'ModalCSController@ajax_modal'
]);

/*RUTA LISTA OCUPACIONES AGREGADAS A UN PRODUCTO*/
Route::get('list_occupation/{id_retailer_product}/{text}', [
    'as' => 'create_modal_list_occupation',
    'uses' => 'ModalOccupationController@ajax_modal'
]);