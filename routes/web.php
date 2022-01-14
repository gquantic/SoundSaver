<?php

use App\Http\Controllers\ParserController;
use Illuminate\Support\Facades\Route;

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

/**
 * Redirect home route to resource view
 */
Route::redirect('/', 'music/index');

/**
 * Routes for resource controllers
 */
Route::resources([
    'music' => \App\Http\Controllers\MusicController::class,
    'compositor' => \App\Http\Controllers\ComposerController::class,
]);

/**
 * Routes for test
 */
Route::get('/urlExecute', function (ParserController $parser) {
    return $parser->init('https://soundcloud.com/lakeyinspired/tracks');
});
