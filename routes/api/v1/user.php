<?php

use App\Http\Controllers\API\V1\DoctorController;
use App\Http\Controllers\API\V1\SpecializationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::get('specializations', [SpecializationController::class, 'index'])
    ->name('specialization.index');

Route::group([
    'as' => 'doctor.',
    'prefix' => 'doctors',
], function () {
    Route::get('/', [DoctorController::class, 'index'])->name('index');
    Route::get('/featured', [DoctorController::class, 'featuredIndex'])->name('featured');
});
