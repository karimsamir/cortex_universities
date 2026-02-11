<?php

declare(strict_types=1);

use Cortex\Universities\Http\Controllers\Adminarea\UniversitiesController;

Route::domain('{adminarea}')->group(function () {
    Route::name('adminarea.')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(route_prefix('adminarea'))->group(function () {
             // Universities Routes
             Route::name('cortex.universities.universities.')->prefix('universities')->group(function () {
                 Route::match(['get', 'post'], '/')->name('index')->uses([UniversitiesController::class, 'index']);
                 Route::post('import')->name('import')->uses([UniversitiesController::class, 'import']);
                 Route::get('create')->name('create')->uses([UniversitiesController::class, 'create']);
                 Route::post('create')->name('store')->uses([UniversitiesController::class, 'store']);
                 Route::get('{university}')->name('show')->uses([UniversitiesController::class, 'show']);
                 Route::get('{university}/edit')->name('edit')->uses([UniversitiesController::class, 'edit']);
                 Route::put('{university}/edit')->name('update')->uses([UniversitiesController::class, 'update']);
                 Route::match(['get', 'post'], '{university}/logs')->name('logs')->uses([UniversitiesController::class, 'logs']);
                 Route::delete('{university}')->name('destroy')->uses([UniversitiesController::class, 'destroy']);
             });
         });
});
