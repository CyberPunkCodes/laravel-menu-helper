<?php

use Illuminate\Support\Facades\Route;
use CyberPunkCodes\MenuHelper\Services\DemoContent;

/**
 * menuhelper demo routes
 *
 * These will only work if `debugMode` is set to `true` in the main/global config by settings the
 * `MH_DEBUGMODE` environment variable to `true` in your `.env` file.
 */
Route::prefix('demo')->name('demo.')->group(function () {

    Route::get('/', function() {
        return view('menuhelper::demo.index-page', ['framework' => null]);
    })->name('index');

    // tailwind demos
    Route::prefix('tailwind')->name('tailwind.')->group(function () {
        Route::get('/', function() {
            return view('menuhelper::demo.tailwind.index-page', ['framework' => 'tailwind']);
        })->name('index');

        Route::get('/basic', function () {
            return view('menuhelper::demo.tailwind.basic-page', ['framework' => 'tailwind']);
        })->name('basic.index');

        Route::prefix('advanced')->name('advanced.')->group(function () {
            Route::get('/', function () {
                return view('tailwind-advanced', ['framework' => 'tailwind']);
            })->name('index');

            DemoContent::loadTailwindRoutes();
        });
    });

    // bootstrap demos
    Route::prefix('bootstrap')->name('bootstrap.')->group(function () {
        Route::get('/', function() {
            return view('menuhelper::demo.bootstrap.index-page', ['framework' => 'tailwind']);
        })->name('index');

        Route::get('/basic', function () {
            return view('menuhelper::demo.bootstrap.basic-page', ['framework' => 'bootstrap']);
        })->name('basic.index');

        Route::prefix('advanced')->name('advanced.')->group(function () {
            Route::get('/', function () {
                return view('menuhelper::demo.bootstrap.advanced-page', ['framework' => 'bootstrap']);
            })->name('index');

            DemoContent::loadBootstrapRoutes();
        });
    });
});
