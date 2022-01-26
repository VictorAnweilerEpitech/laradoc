<?php

use Illuminate\Support\Facades\Route;

use Victoranw\Laradoc\Http\Controllers\AssetsController;
use Victoranw\Laradoc\Http\Home\Controllers\HomeController;
use Victoranw\Laradoc\Http\Page\Controllers\PageController;
use Victoranw\Laradoc\Http\Member\Controllers\MemberController;
use Victoranw\Laradoc\Http\Client\Controllers\ClientController;
use Victoranw\Laradoc\Http\Structure\Controllers\StructureController;
use Victoranw\Laradoc\Http\Authentication\Controllers\LoginController;

Route::prefix(config('laradoc.url_prefix'))->group(function () {
    // Styles
    Route::get('/scripts/{script}', [AssetsController::class, 'scriptFile'])->where('script', '(.*)')->name('laradoc.assets.js');
    Route::get('/styles/{style}', [AssetsController::class, 'styleFile'])->where('style', '(.*)')->name('laradoc.assets.css');

    // Routes
    Route::get('/login', [LoginController::class, 'loginView'])->name('laradoc.view.login');
    Route::post('/connect', [LoginController::class, 'connect'])->name('laradoc.back.auth.connect');
    Route::get('/logout', [LoginController::class, 'logout'])->name('laradoc.back.auth.logout');

    Route::group(['middleware' => ['authDoc']], function () {
        Route::get('/', [ClientController::class, 'home'])->name('laradoc.client.home');
        Route::get('/page/{page}', [ClientController::class, 'page'])->name('laradoc.client.page');

        // Admin space
        Route::group(['middleware' => ['adminDoc']], function () {            
            Route::prefix('/structure')->group(function () {
                Route::post('/search', [StructureController::class, 'search'])->name('laradoc.back.structure.search');
                Route::post('/browse', [StructureController::class, 'structure'])->name('laradoc.back.structure.browse');
                Route::post('/create', [StructureController::class, 'create'])->name('laradoc.back.structure.create');
                Route::post('/{category}/voir', [StructureController::class, 'view'])->name('laradoc.back.structure.view');
                Route::post('/{category}/update', [StructureController::class, 'update'])->name('laradoc.back.structure.delete');
                Route::post('/{category}/delete', [StructureController::class, 'delete'])->name('laradoc.back.structure.delete');
            });

            Route::prefix('/page')->group(function () {
                Route::post('/create', [PageController::class, 'create'])->name('laradoc.back.page.create');
                Route::post('/browse/category/{categoryId}', [PageController::class, 'browseByCategorie'])->name('laradoc.back.page.browse-categorie');
                Route::post('/{page}/view', [PageController::class, 'view'])->name('laradoc.back.page.view');
                Route::post('/{page}/update', [PageController::class, 'update'])->name('laradoc.back.page.update');
                Route::post('/{page}/delete', [PageController::class, 'delete'])->name('laradoc.back.page.delete');
            });

            Route::prefix('/member')->group(function () {
                Route::post('/browse/not-allow', [MemberController::class, 'browseNotAllow'])->name('laradoc.back.not-allow');
                Route::post('/browse/allow', [MemberController::class, 'browseAllow'])->name('laradoc.back.member.allow');
                Route::post('/allow/{member}', [MemberController::class, 'allow'])->name('laradoc.back.member.allow');
                Route::post('/remove-allow/{member}', [MemberController::class, 'removeAllow'])->name('laradoc.back.member.remove-allow');
                Route::post('/change-permission/{member}', [MemberController::class, 'changePermission'])->name('laradoc.back.change-permission');
            });

            Route::get('/admin/{any}', [HomeController::class, 'admin'])->where('any', '.*'); 
        });
    });
});
