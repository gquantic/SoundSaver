<?php

use App\Http\Controllers\ComposerController;
use App\Http\Controllers\MusicController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

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
Route::get('/', function () {
    return view('music.index', ['composers' => \App\Models\Composer::all()]);
});

/**
 * Routes for resource controllers
 */
Route::resources([
    'music' => MusicController::class,
    'compositor' => ComposerController::class,
]);

Route::view('/form', 'parse.form');

Route::post('/parse/url', function (MusicController $musicController, ComposerController $composerController) {
    $parserController = new \App\Http\Controllers\ParserController;
    $parserController->init($_POST['url'], $composerController, $musicController);

    return redirect('/')->with('success', 'Вы успешно спарсили песни.');
});
