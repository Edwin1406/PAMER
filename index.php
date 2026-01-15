<?php 
    


// error_reporting(E_ALL);
// ini_set('display_errors', 1);



require_once __DIR__ . '/includes/app.php';

use MVC\Router;

use Controllers\AuthController;
use Controllers\AdminController;
use Controllers\BodegaController;
use Controllers\NotaPedidoController;
use Controllers\PruebasController;


$router = new Router();


// Login
$router->get('/', [AuthController::class, 'login']);
$router->post('/', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);


// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
// $router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);



// Area de Administración
$router->get('/admin/index', [AdminController::class, 'index']);



// Dashboard




// Crear bodega
$router->get('/admin/bodega/crearBodega', [BodegaController::class, 'crearBodega']);
$router->post('/admin/bodega/crearBodega', [BodegaController::class, 'crearBodega']);

// tabla de bodega
$router->get('/admin/bodega/tablaBodega', [BodegaController::class, 'tablaBodega']);

// eliminar bodega
$router->post('/admin/eliminarBodega', [BodegaController::class, 'eliminarBodega']);

// editar bodega
$router->get('/admin/bodega/editarBodega', [BodegaController::class, 'editarBodega']);
$router->post('/admin/bodega/editarBodega', [BodegaController::class, 'editarBodega']);


// crearCiudad
$router->get('/admin/ciudad/crearCiudad', [BodegaController::class, 'crearCiudad']);
$router->post('/admin/ciudad/crearCiudad', [BodegaController::class, 'crearCiudad']);


// creartienda
$router->get('/admin/tienda/crearTienda', [BodegaController::class, 'crearTienda']);
$router->post('/admin/tienda/crearTienda', [BodegaController::class, 'crearTienda']);


// tabla de tiendas
$router->get('/admin/tienda/tablaTienda', [BodegaController::class, 'tablaTienda']);


// editar tienda
$router->get('/admin/tienda/editarTienda', [BodegaController::class, 'editarTienda']);
$router->post('/admin/tienda/editarTienda', [BodegaController::class, 'editarTienda']);








// tabla de ciudad
$router->get('/admin/ciudad/tablaCiudad', [BodegaController::class, 'tablaCiudad']);

// eliminar 
$router->post('/admin/eliminarCiudad', [BodegaController::class, 'eliminarCiudad']);

// editar ciudad
$router->get('/admin/ciudad/editarCiudad', [BodegaController::class, 'editarCiudad']);
$router->post('/admin/ciudad/editarCiudad', [BodegaController::class, 'editarCiudad']);


//crearMarca
$router->get('/admin/marca/crearMarca', [BodegaController::class, 'crearMarca']);
$router->post('/admin/marca/crearMarca', [BodegaController::class, 'crearMarca']);


//tabla de marca
$router->get('/admin/marca/tablaMarca', [BodegaController::class, 'tablaMarca']);


// eliminar marca
$router->post('/admin/eliminarMarca', [BodegaController::class, 'eliminarMarca']);

// editar marca
$router->get('/admin/marca/editarMarca', [BodegaController::class, 'editarMarca']);
$router->post('/admin/marca/editarMarca', [BodegaController::class, 'editarMarca']);




// crearPais
$router->get('/admin/paises/crearPais', [BodegaController::class, 'crearPais']);
$router->post('/admin/paises/crearPais', [BodegaController::class, 'crearPais']);

// tabla de paises
$router->get('/admin/paises/tablaPais', [BodegaController::class, 'tablaPais']);

// eliminar pais
$router->post('/admin/eliminarPais', [BodegaController::class, 'eliminarPais']);

// editar pais
$router->get('/admin/paises/editarPais', [BodegaController::class, 'editarPais']);
$router->post('/admin/paises/editarPais', [BodegaController::class, 'editarPais']);







// CRUD DE NOTA PEDIDO
// Crear nota
$router->get('/admin/notaPedido/crearNota', [NotaPedidoController::class, 'crearNota']);
$router->post('/admin/notaPedido/crearNota', [NotaPedidoController::class, 'crearNota']);


// Lista de notas
$router->get('/admin/notaPedido/listaNotaPedido', [NotaPedidoController::class, 'listaNotaPedido']);


//tiendas 

$router->get('/admin/notaPedido/crearTienda', [NotaPedidoController::class, 'crearTienda']);
$router->post('/admin/notaPedido/crearTienda', [NotaPedidoController::class, 'crearTienda']);





// CRUD DE PRUEBAS 
// Crear prueba
$router->get('/admin/pruebas/crearPruebas', [PruebasController::class, 'crearPruebas']);
$router->post('/admin/pruebas/crearPruebas', [PruebasController::class, 'crearPruebas']);


// crearPruebasAjax
$router->post('/admin/pruebas/crearPruebasAjax', [PruebasController::class, 'crearPruebasAjax']);

// CREAR PRENDA
$router->post('/admin/prenda/crearPrenda', [PruebasController::class, 'crearPrenda']);


// eliminar carrito
$router->post('/admin/eliminarCarrito', [PruebasController::class, 'eliminarCarrito']);

// REGISTRAR VENTA
$router->post('/admin/pruebas/registrarVenta', [PruebasController::class, 'registrarVenta']);


// actualizar  
$router->post('/admin/pruebas/actualizarPruebas', [PruebasController::class, 'actualizarPruebas']);


// ver pdf 
$router->get('/admin/pruebas/pdf', [PruebasController::class, 'pdf']);









// cerrar sesión
$router->get('/cerrarSesion', [AuthController::class, 'cerrarSesion']);



$router->comprobarRutas();






