<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\RecipesController;

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('recipes', \App\Http\Controllers\RecipesController::class);
//Route::resource('mgmtusr', \App\Http\Controllers\ManagementUsersController::class);

//enumUsers
//Route::post('reset-password', 'App\Http\Controllers\Auth\PasswordResetLinkController@store')
//    ->name('password.email')
//    ->middleware('guest');
//Route::post('register', 'App\Http\Controllers\Auth\RegisteredUserController@store')
//    ->middleware('guest');

Route::middleware([
    'guest'
])->group(function () {
    Route::post('reset-password', 'App\Http\Controllers\Auth\PasswordResetLinkController@store')
        ->name('password.email');
    Route::post('register', 'App\Http\Controllers\Auth\RegisteredUserController@store');

});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    //recipes
    Route::resource('recipes', \App\Http\Controllers\RecipesController::class);
    //gestion de usuarios
    Route::resource('mgmtusr', \App\Http\Controllers\ManagementUsersController::class);
    Route::get('/mgmtusr/{id}/edtpwd',
        [\App\Http\Controllers\ManagementUsersController::class, 'editpassword'])
        ->name('mgmtusr.edtpwd');
    Route::post('/mgmtusr/upwd',
        [\App\Http\Controllers\ManagementUsersController::class, 'updatepassword'])
        ->name('mgmtusr.storepwd');


//    Route::prefix('shared-catalog')->group(function () {
//        Route::resource('items-catalog', SharedCatalog\SharedCatalogController::class);
//        //serach in catalog
//        Route::post('search-item', [SharedCatalog\SharedCatalogController::class, 'searchInCatalogItem'])->name('shared.catalog.search.item');
//        Route::post('store-item', [SharedCatalog\SharedCatalogController::class, 'storeCatalogItem'])->name('store.catalog.item');
//
//    });


//    PUT|PATCH       mgmtusr/{mgmtusr} ......................................... mgmtusr.update › ManagementUsersController@update
//    GET|HEAD        mgmtusr/{mgmtusr}/edit .................................... mgmtusr.edit › ManagementUsersController@edit


});
