<?php

use App\Modules\Pet\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
Route::post('/pets/{id}/uploadImage', [PetController::class, 'uploadImage'])->name('pets.upload.image');
Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');
Route::get('/pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');
Route::put('/pets', [PetController::class, 'update'])->name('pets.update');
Route::post('/pets/{id}', [PetController::class, 'partialUpdate'])->name('pets.update.partial');
Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');

