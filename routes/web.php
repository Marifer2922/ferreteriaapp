<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProductoController;

Route::get('/hola', function () {
    return ('hola mundo programacion wweb');
});

Route::get('/hola2', function () {
    return view('prueba', [
        'empresa' => 'Ferretería La Bendición24'
    ]);
});

Route::resource('productos', ProductoController::class);

Route::get('/', function () {
    return redirect()->route('productos.index');
});

// Recursos Humanos: muestra los empleados de la tabla 'empleados'
Route::get('/empleados', function () {
    $empleados = DB::table('empleados')->get();
    return view('empleados.index', compact('empleados'));
})->name('empleados.index');