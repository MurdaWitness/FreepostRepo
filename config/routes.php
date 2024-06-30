<?php

use App\Controllers\AdminController;
use App\Controllers\HomeController;
use App\Controllers\LoginController;
use App\Controllers\ModuleController;
use App\Controllers\RegisterController;
use App\Kernel\Router\Route;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

return [
    Route::get('/', [HomeController::class, 'index']),
    Route::get('/about', [HomeController::class, 'about']),

    Route::get('/register', [RegisterController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/register', [RegisterController::class, 'register']),

    Route::get('/login', [LoginController::class, 'index'], [GuestMiddleware::class]),
    Route::post('/login', [LoginController::class, 'login']),
    Route::get('/logout', [LoginController::class, 'logout'], [AuthMiddleware::class]),

    Route::get('/modules', [ModuleController::class, 'index']),
    Route::get('/module', [ModuleController::class, 'show']),
    Route::get('/module/download', [ModuleController::class, 'download']),

    Route::get('/profile', [ModuleController::class, 'profile'], [AuthMiddleware::class]),

    Route::get('/profile/add', [ModuleController::class, 'add'], [AuthMiddleware::class]),
    Route::post('/profile/add', [ModuleController::class, 'store'], [AuthMiddleware::class]),

    Route::get('/profile/edit', [ModuleController::class, 'edit'], [AuthMiddleware::class]),
    Route::post('/profile/edit', [ModuleController::class, 'change'], [AuthMiddleware::class]),

    Route::get('/profile/delete', [ModuleController::class, 'delete'], [AuthMiddleware::class]),

    Route::get('/admin', [AdminController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]),

    Route::get('/admin/modules', [AdminController::class, 'modules'], [AuthMiddleware::class, AdminMiddleware::class]),

    Route::get('/admin/modules/add', [AdminController::class, 'moduleAdd'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::post('/admin/modules/add', [AdminController::class, 'moduleStore'], [AuthMiddleware::class, AdminMiddleware::class]),

    Route::get('/admin/modules/edit', [AdminController::class, 'moduleEdit'], [AuthMiddleware::class, AdminMiddleware::class]),
    Route::post('/admin/modules/edit', [AdminController::class, 'moduleChange'], [AuthMiddleware::class, AdminMiddleware::class]),

    Route::get('/admin/modules/delete', [AdminController::class, 'moduleDelete'], [AuthMiddleware::class, AdminMiddleware::class]),
];