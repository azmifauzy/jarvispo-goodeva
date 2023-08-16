<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [DashboardController::class, 'index']);
Route::post('/purchases', [DashboardController::class, 'store']);
Route::get('/purchases/{purchase}/edit', [DashboardController::class, 'edit']);
Route::put('/purchases/{purchase}', [DashboardController::class, 'update']);
Route::delete('/purchases/{purchase}', [DashboardController::class, 'destroy']);


Route::post('/purchases/imports', [DashboardController::class, 'import_excel']);
Route::get('/purchases/exports', [DashboardController::class, 'export_excel']);
Route::get('/statistics', [DashboardController::class, 'getStatistik']);