<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\CollectionController;
use App\Http\Controllers\Functionality\ManageCollection;
use App\Http\Controllers\Functionality\ManageAuth;
use App\Http\Controllers\Pages\AuthenticationController;

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

Route::get('/', function () {
    return redirect()->route('home');
});

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::group(['middleware' => 'guest'], function () {
            Route::get('login', [AuthenticationController::class, 'renderLogin'])->name('get.login');
            Route::get('register', [AuthenticationController::class, 'renderRegister'])->name('get.register');

            Route::post('login', [ManageAuth::class, 'processLogin'])->name('post.login');
            Route::post('register', [ManageAuth::class, 'processRegisteration'])->name('post.register');
        });
        Route::get('logout', [ManageAuth::class, 'processLogout'])->name('get.logout');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('home', [HomeController::class, 'renderHome'])->name('home');
        Route::get('collections', [CollectionController::class, 'renderViewCollections'])->name('get.collections');
        Route::get('collection', [CollectionController::class, 'renderViewCollection'])->name('get.collection');
        Route::get('collection/book/add', [CollectionController::class, 'renderAddBook'])->name('get.collection_add');
        Route::post('collection/book/add/new', [ManageCollection::class, 'processAddBookNewCollection'])->name('post.collection_add');
        Route::post('collection/book/add/existing', [ManageCollection::class, 'processAddBookExistingCollection'])->name('post.collection_existing');
        Route::post('collection/book/remove', [ManageCollection::class, 'processRemoveBookCollection'])->name('post.collection_remove_book');
        Route::post('collection/book/move', [ManageCollection::class, 'processMoveBook'])->name('post.move_book');
    });
});
