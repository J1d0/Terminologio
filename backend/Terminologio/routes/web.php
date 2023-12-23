<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IllustrationController;
use App\Http\Controllers\UserController;

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

// Authentification routes
Auth::routes();

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin routes
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');

// Illustration routes
Route::get('/illustration/add', [IllustrationController::class, 'add'])->name('illustration.add');
Route::post('/illustration', [IllustrationController::class, 'store'])->name('illustration.store');
Route::get('/illustration/{illustration}/edit', [IllustrationController::class, 'edit'])->name('illustration.edit');
Route::put('/illustration/{illustration}', [IllustrationController::class, 'update'])->name('illustration.update');
Route::delete('/illustration/{illustration}', [IllustrationController::class, 'destroy'])->name('illustration.destroy');
Route::get('/illustration/{illustration}', [IllustrationController::class, 'show'])->name('illustration.show');
Route::post('/illustration/{illustration}/components', [IllustrationController::class, 'designateComponents'])->name('illustration.designateComponents');
Route::get('/illustration/{illustration}/translations', [IllustrationController::class, 'manageTranslations'])->name('illustration.manageTranslations');

// User routes
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register');

// Groupement des routes administratives avec le middleware 'role'
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    // Ajoutez ici d'autres routes administratives si nécessaire
});