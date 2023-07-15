<?php

use Illuminate\Support\Facades\Route;
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

// Route::get('/classrooms', [ClassroomsController::class, 'index'])->name('classrooms.index');
// Route::post('/classrooms', [ClassroomsController::class, 'store'])->name('classrooms.store');

// Route::get('/classrooms/{classroom}', [CLassroomsController::class, 'show'])->name('classrooms.show')->where('classroom', '\d+');

// Route::get('/classrooms/create', [CLassroomsController::class, 'create'])->name('classrooms.create');

// Route::get('/classrooms/{classroom}/edit', [ClassroomsController::class, 'edit'])->name('classrooms.edit')->where([
//     'classroom' => '\d+',
// ]);
// Route::put('/classrooms/{classroom}', [ClassroomsController::class, 'update'])->name('classrooms.update')->where([
//     'classroom' => '\d+',
// ]);
// Route::delete('/classrooms/{classroom}', [ClassroomsController::class, 'destroy'])->name('classrooms.destroy')->whereNumber('id');

Route::resource('/classrooms',ClassroomsController::class)
->names([
    // 'index'     =>  'classrooms/index',
    // 'create'    =>  'classrooms/create',
]);
//->where(['classroom' => '\d+']);
Route::resources([
    // 'topics'    =>  TopicsController::class ,
    'classrooms'    =>  ClassroomsController::class
]);
