<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Dashboard\CategoriaController;
use App\Http\Controllers\Dashboard\Dashboard;
use App\Http\Controllers\Dashboard\ExcelController;
use App\Http\Controllers\Dashboard\ReporteController;
use App\Http\Controllers\Dashboard\TransaccionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;





//register
Route::get('/register', [Register::class, 'index'])->name('register');
Route::post('/register', [Register::class, 'store'])->name('register.store');


Route::get('/login', [Login::class, 'index'])->name('login');
Route::post('/login', [Login::class, 'login'])->name('login.store');
Route::get('/logout', [Logout::class, 'logout'])->name('logout');




Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/dashboard', [Dashboard::class, 'dashboard'])->name('dashboard');

    //transaccion
    Route::get('/transaccion', [TransaccionController::class, 'index'])->name('transaccion');
    Route::post('/transaccion/store', [TransaccionController::class, 'store'])->name('transaccion.store');
    Route::get('/transaccion/edit/{transaccion}', [TransaccionController::class, 'edit'])->name('transaccion.edit');
    Route::put('/transaccion/update/{transaccion}', [TransaccionController::class, 'update'])->name('transaccion.update');
    Route::delete('/transaccion/delete/{transaccion}', [TransaccionController::class, 'delete'])->name('transaccion.delete');

    //categoria
    Route::get('/categoria', [CategoriaController::class, 'index'])->name('categoria');
    Route::get('/categoria/create', [CategoriaController::class, 'create'])->name('categoria.create');
    Route::post('/categoria/store', [CategoriaController::class, 'store'])->name('categoria.store');
    Route::put('/categoria/update/{categoria}', [CategoriaController::class, 'update'])->name('categoria.update');
    Route::delete('/categoria/delete/{categoria}', [CategoriaController::class, 'delete'])->name('categoria.delete');

    //excel
    Route::get('/transaccion/export',[ExcelController::class,'export'])->name('transaccion.export');
    Route::post('/transaccion/import',[ExcelController::class,'import'])->name('transaccion.import');

    //reportes
    Route::get('/reporte',[ReporteController::class,'index'])->name('reporte');
});