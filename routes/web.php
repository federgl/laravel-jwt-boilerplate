<?php

if (true === \class_exists(\Rap2hpoutre\LaravelLogViewer\LogViewerController::class)) {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
}

#Return welcome view
Route::view('/', 'welcome');
