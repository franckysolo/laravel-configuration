<?php

use Illuminate\Support\Facades\Route;

Route::resource('configurations', 'ConfigurationController');
Route::get('configuration-test', function () {
    return 'Hello from the configuration form package is symlink';
});
