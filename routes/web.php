<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassroomsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('classrooms/trashed', [ClassroomsController::class, 'trashed'])->name('classrooms.trashed');

Route::put('classrooms/trashed/{classroom}', [ClassroomsController::class, 'restore'])->name('classrooms.restore');

Route::put('classrooms/trashed/{classroom}', [ClassroomsController::class, 'forceDelete'])->name('classrooms.force-delete');

Route::resource('/classrooms', ClassroomsController::class)->names([
    //'index' => 'classrooms/index',
    // 'create' => 'classrooms/create'
], [
    'middleware' => ['auth']
]);

Route::prefix('/classrooms/{classroom}/topics')->name('topics.')->group(function () {
    Route::get('/', [TopicsController::class, 'index'])->name('index');
    Route::get('/create', [TopicsController::class, 'create'])->name('create');
    Route::post('/', [TopicsController::class, 'store'])->name('store');

    Route::prefix('/trashed')
        ->group(function () {

            Route::get('/', [TopicsController::class, 'trashed'])->name('trashed');

            Route::put('/{topic}', [TopicsController::class, 'restore'])->name('restore');

            Route::delete('/{topic}', [TopicsController::class, 'forceDelete'])->name('force-delete');
        });

    Route::get('/{topic}', [TopicsController::class, 'show'])->name('show');
    Route::get('/{topic}/edit', [TopicsController::class, 'edit'])->name('edit');
    Route::put('/{topic}', [TopicsController::class, 'update'])->name('update');
    Route::delete('/{topic}', [TopicsController::class, 'destroy'])->name('destroy');
});
