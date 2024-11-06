<?php 
 
require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIcontroller;
use Controllers\CitaController;
use MVC\Router;
use Controllers\LoginController;
use Controllers\ServicioController;

$router = new Router();
 
 
//Iniciar Sesion
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
$router->get('/logout',[LoginController::class,'logout']);
 
//Recuperar Password
$router->get('/olvide',[LoginController::class,'olvide']);
$router->post('/olvide',[LoginController::class,'olvide']);
$router->get('/recuperar',[LoginController::class,'recuperar']);
$router->post('/recuperar',[LoginController::class,'recuperar']); 

// Crear cuentas
$router->get('/crear-cuenta',[LoginController::class,'crear']);
$router->post('/crear-cuenta',[LoginController::class,'crear']);

//Confirmar cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

//Area privada
$router->get('/cita', [CitaController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);

//API de citas

$router->get('/api/servicios', [APIcontroller::class, 'index']);
$router->post('/api/citas', [APIcontroller::class, 'guardar']);
$router->post('/api/eliminar', [APIcontroller::class, 'eliminar']);
$router->post('/api/reservar-cita', [CitaController::class, 'reservar']);




//CRUD de servicios

$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();