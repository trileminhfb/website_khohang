<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\NhapKhoController;
use App\Http\Controllers\Api\XuatKhoController;
use App\Http\Controllers\Api\HangHoaController;
use App\Http\Controllers\DashboardController;


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

Route::post('/nhap-kho/tao-phieu/store', [NhapKhoController::class, 'store'])->name('api.nhap-kho.store');
Route::post('/nhap-kho/tao-phieu/them-hang', [NhapKhoController::class, 'add'])->name('api.them-hang.add');

Route::post('/xuat-kho/tao-phieu/store', [XuatKhoController::class, 'store'])->name('api.xuat-kho.store');
Route::post('/xuat-kho/tao-phieu/export', [XuatKhoController::class, 'export'])->name('api.xuat-kho.export');
Route::get('/xuat-kho/tao-phieu', [XuatKhoController::class, 'search'])->name('api.xuat-kho.search');

Route::post('/hang-hoa', [HangHoaController::class, 'import'])->name('api.them-hang.import');
Route::get('/doanh-thu', [DashboardController::class, 'doanhThu'])->name('api.doanh-thu');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
