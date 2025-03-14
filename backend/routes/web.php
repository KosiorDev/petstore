<?php

use App\Modules\Pet\Controllers\PetController;
use Illuminate\Support\Facades\Route;


Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
Route::get('/pets/{id}/edit', [PetController::class, 'edit'])->name('pets.edit');
Route::get('/pets/{id}/partialEdit', [PetController::class, 'partialEdit'])->name('pets.edit.partial');


Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');
Route::put('/pets', [PetController::class, 'update'])->name('pets.update');
Route::post('/pets/{id}/uploadImage', [PetController::class, 'uploadImage'])->name('pets.upload.image');
Route::post('/pets/{id}', [PetController::class, 'partialUpdate'])->name('pets.update.partial');
Route::delete('/pets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');
