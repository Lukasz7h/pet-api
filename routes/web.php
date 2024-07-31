<?php

use App\Http\Controllers\PetsActions;
use App\Http\Middleware\clickjacking;
use App\Http\Middleware\validPetId;

use App\Http\Middleware\validStatus;
use Illuminate\Support\Facades\Route;

// Add new pet to API
Route::prefix('/add-pet/')->group(function (){
    Route::get('/', fn() => view('addPetForm'))->middleware([clickjacking::class]);
    Route::post('/', [PetsActions::class, 'addPet'])->name('add');
});

// Update pet in API
Route::prefix('/update-pet/')->group(function (){
    Route::get('/', fn() => view('updatePet'))->middleware([clickjacking::class]);
    Route::post('/', [PetsActions::class, 'updatePet'])->name('update');
});

// Delete pet from API
Route::prefix('/delete/')->group(function(){
    Route::get('/', fn() => view('deletePet'))->middleware([clickjacking::class]);
    Route::delete('/', [PetsActions::class, 'deletePet'])->name('delete');
});

// Get pet from API by ID or status
Route::middleware([validPetId::class])->get('/pet/{id}/', [PetsActions::class, 'fetchPetBy']);
Route::middleware([validStatus::class])->get('/pet/findByStatus/{status}/', [PetsActions::class, 'fetchPetBy']);
