<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Session;

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


/**
 * URL's de todas las vistas de la aplicación
 */
Route::get('/', function () {
    if (!session('logueado')) {
        return view('welcome');
    } else {
        return redirect()->to('/cliente/listar')->send();
    }
});

Route::get('/cliente/listar', function () {
    if (session('logueado')) {
        return view('cliente.list');
    } else {
        return redirect()->to('/')->send();
    }
});

Route::get('/cliente/{id}/servicios', function () {
    if (session('logueado')) {
        $datos = explode('/', Request::fullUrl());
        $var = $datos[4];
        return view('cliente.services')->with('id', $var);
    } else {
        return redirect()->to('/')->send();
    }
});

Route::get('/salir', function () {
    Session::forget('logueado');
    return redirect()->to('/')->send();
});

/**
 * URL's de todas las peticiones de la vistas al backend
 */

Route::get('/listarClientes', [ClientesController::class, 'index']);

Route::post('/crearCliente', [ClientesController::class, 'store']);

Route::post('/eliminarCliente', [ClientesController::class, 'destroy']);

Route::get('/listarCliente/{id}', [ClientesController::class, 'show']);


/**
 * URL's de los servicios
 */
Route::post('/crearEditarServicio', [ServiciosController::class, 'store']);

Route::get('/listarServicios/{id}', [ServiciosController::class, 'index']);

Route::post('/eliminarServicio', [ServiciosController::class, 'destroy']);

Route::get('/listarServicio/{id}', [ServiciosController::class, 'show']);

Route::get('/listarServiciosCliente', [ServiciosController::class, 'listaServicesCliente']);

/**
 * Url's Registro y login
 */

Route::post('/crearUsuario', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'show']);