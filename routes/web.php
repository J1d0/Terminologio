<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\IllustrationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Role;

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

// Illustration routes
Route::get('/illustration/add', [IllustrationController::class, 'add'])->name('illustration.add');
Route::post('/illustration', [IllustrationController::class, 'newIllustration'])->name('illustration.newIllustration');
Route::get('/illustration/cancel/{imagePath}', [IllustrationController::class, 'cancel'])->name('illustration.cancel');
Route::get('/illustration/design_comp/{imageTitle}/{domain}/{language}/{imagePath}', [IllustrationController::class, 'design_comp'])->name('illustration.design_comp');
Route::post('/illustration/{imageTitle}/{domain}/{language}/{imagePath}', [IllustrationController::class, 'store'])->name('illustration.store');

Route::get('/illustration/edit/{imagePath}/{language}', [IllustrationController::class, 'edit'])->name('illustration.edit');
Route::post('/illustration/updateComponents/{image_path}/{language}', [IllustrationController::class, 'updateComponents'])->name('illustration.updateComponents');

Route::get('/illustration/{image_path}', [IllustrationController::class, 'show'])->name('illustration.show');

Route::get('/illustration/translations/{imagePath}', [IllustrationController::class, 'manageTranslations'])->name('illustration.manageTranslations');
Route::post('/illustration/translations/{imagePath}', [IllustrationController::class, 'editTranslation'])->name('illustration.editTranslation');


// User routes
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [UserController::class, 'login'])->name('login.post');

// Deconnexion 
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Groupement des routes administratives avec le middleware 'role'
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'manage'])->name('admin.manage');
    Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::delete('/admin/illustrations/{image_path}', [AdminController::class, 'deleteIllustration'])->name('admin.deleteIllustration');
});