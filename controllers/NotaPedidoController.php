<?php

namespace Controllers;

use Model\Carrito;
use Model\Carrito2;
use Model\Ciudad;
use Model\DetalleVenta;
use Model\Exportadores;
use Model\Importadores;
use Model\Marca;
use Model\NotaPedido;
use Model\Pais;
use Model\Tienda;
use Model\TiendaNota;
use Model\Ventas;
use MVC\Router;

class NotaPedidoController
{
    public static function crearNota(Router $router): void
    {
        $alertas = [];

        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $importadores = Importadores::all();
        $exportadores = Exportadores::all();
        $pais = Pais::all();
        $notasPedidos = NotaPedido::all();

       // Obtener el último código de nota pedido del último registro
$ultimoCodigo = NotaPedido::ultimoCodigo();

// Depurar el valor
// debuguear($ultimoCodigo);


        $notaPedido = new NotaPedido;





        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $Codigo_Nota_Pedido = $_POST['Codigo_Nota_Pedido'] ?? 0;
            $existeNotaPedido = NotaPedido::where('Codigo_Nota_Pedido', $Codigo_Nota_Pedido);
            if ($existeNotaPedido) {
                // Mensaje de error
                NotaPedido::setAlerta('error', 'Ya existe una Nota Pedido con ese código');
                $alertas = NotaPedido::getAlertas();
            } else {
                // Crea una nueva instancia
                $notaPedido = new NotaPedido($_POST);
            }

            // Sincronizar objeto con los datos del formulario
            $notaPedido->sincronizar($_POST);

            // Validar los datos
            $alertas = $notaPedido->validar();

            if (empty($alertas)) {
                // Guardar el registro
                $resultado = $notaPedido->guardar();

                if ($resultado) {
                    header('Location: /admin/notaPedido/listaNotaPedido?exito=1');
                }
            }
        }

        // Renderizar la vista
        $router->render('admin/notapedido/crearNota', [
            'titulo' => 'Crear Nota Pedido',
            'nombre' => $nombre,
            'email' => $email,
            'alertas' => $alertas,
            'importadores' => $importadores,
            'exportadores' => $exportadores,
            'pais' => $pais,
            'notasPedidos' => $notasPedidos,
            'ultimoCodigo' => $ultimoCodigo,
        ]);
    }



    // Lista de notas pedido
    public static function listaNotaPedido(Router $router): void
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $notasPedidos = NotaPedido::all();

        // Renderizar la vista
        $router->render('admin/notapedido/listaNotaPedido', [
            'titulo' => 'Lista de Notas de Pedido',
            'nombre' => $nombre,
            'email' => $email,
            'notasPedidos' => $notasPedidos,
        ]);
    }


    // Crear Tienda
    // public static function crearTienda(Router $router): void
    // {
    //     $alertas = [];

    //     session_start();
    //     if (!isset($_SESSION['email'])) {
    //         header('Location: /');
    //     }


    //     // Obtener id de nota pedido
    //     $id_nota_pedido = $_GET['id'] ?? 0;
    //     // sanitize
    //     $id_nota_pedido = filter_var($id_nota_pedido, FILTER_SANITIZE_NUMBER_INT);

      
    //     $nombre = $_SESSION['nombre'];
    //     $email = $_SESSION['email'];

    //     $tiendas = Tienda::all();
    //     $ciudad  = Ciudad::all();
    //     $paises    = Pais::all();
    //     $marca   = Marca::all();





    //     $informacionNota = NotaPedido::where('Codigo_Nota_Pedido', $id_nota_pedido);
    //     // debuguear($notaPedido);

    //     $tiendaNota = new TiendaNota;

    //     $tiendaNotas = TiendaNota::wherenuevo('Codigo_Nota_Pedido', $id_nota_pedido);

        
        
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
    //         // Crea una nueva instancia
    //         $tiendaNota = new TiendaNota($_POST);
    //         $id_nota_pedido = $_POST['id_nota_pedido'] ?? 0;  // Usar POST para obtener el id
    //         $tiendaNota->Codigo_Nota_Pedido = $id_nota_pedido;
    //         // debuguear($tiendaNota);

    //         // Sincronizar objeto con los datos del formulario
    //         $tiendaNota->sincronizar($_POST);

    //         // Validar los datos
    //         $alertas = $tiendaNota->validar();

    //         if (empty($alertas)) {
    //             // Guardar el registro
    //             $resultado = $tiendaNota->guardar();

    //             if ($resultado) {
    //                 header('Location: /admin/notaPedido/crearTienda?id=' . $id_nota_pedido . '&exito=1');
    //             }
    //         }
    //     }

    //     // Renderizar la vista
    //     $router->render('admin/notapedido/crearTienda', [
    //         'titulo' => 'Crear Tienda para Nota de Pedido',
    //         'nombre' => $nombre,
    //         'email' => $email,
    //         'alertas' => $alertas,
    //         'tiendaNota' => $tiendaNota,
    //         'id_nota_pedido' => $id_nota_pedido,
    //         'tiendaNotas' => $tiendaNotas,
    //         'informacionNota' => $informacionNota,
    //         'tiendas' => $tiendas,
    //         'ciudad' => $ciudad,
    //         'paises' => $paises,
    //         'marca' => $marca,
    //     ]);
    // }



public static function crearTienda(Router $router): void
{
    session_start();

    // Si no hay sesión, redirigir
    if (!isset($_SESSION['email'])) {
        header('Location: /');
        exit;
    }

    // 1) Obtener ID de forma robusta (GET primero, si no, POST)
    $id_nota_pedido = $_GET['id'] ?? ($_POST['id_nota_pedido'] ?? 0);
    $id_nota_pedido = filter_var($id_nota_pedido, FILTER_SANITIZE_NUMBER_INT);

    // Si no viene ID válido, manda a un lugar seguro
    if (!$id_nota_pedido) {
        header('Location: /admin/notaPedido');
        exit;
    }

    $nombre = $_SESSION['nombre'] ?? '';
    $email  = $_SESSION['email'] ?? '';

    // 2) Cargar datos para selects, etc.
    $tiendas = Tienda::all();
    $ciudad  = Ciudad::all();
    $paises  = Pais::all();
    $marca   = Marca::all();

    // 3) Info relacionada a la nota
    $informacionNota = NotaPedido::where('Codigo_Nota_Pedido', $id_nota_pedido);

    $tiendaNota  = new TiendaNota;
    $tiendaNotas = TiendaNota::wherenuevo('Codigo_Nota_Pedido', $id_nota_pedido);

    // 4) Recuperar flash (alertas y old) si vienes de un redirect por error
    $alertas = $_SESSION['alertas'] ?? [];
    $old     = $_SESSION['old'] ?? [];

    // Limpiar flash para que no quede pegado
    unset($_SESSION['alertas'], $_SESSION['old']);

    // 5) Procesar POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Crear instancia con POST
        $tiendaNota = new TiendaNota($_POST);

        // Asegurar el ID desde POST (y volver a sanitizar)
        $id_post = $_POST['id_nota_pedido'] ?? $id_nota_pedido;
        $id_post = filter_var($id_post, FILTER_SANITIZE_NUMBER_INT);

        $tiendaNota->Codigo_Nota_Pedido = $id_post;

        // Sincronizar
        $tiendaNota->sincronizar($_POST);

        // Validar
        $alertas = $tiendaNota->validar();

        // Si hay errores: guardar en sesión y REDIRIGIR manteniendo ?id=
        if (!empty($alertas)) {
            $_SESSION['alertas'] = $alertas;
            $_SESSION['old'] = $_POST; // opcional para repoblar campos

            header('Location: /admin/notaPedido/crearTienda?id=' . $id_post);
            exit;
        }

        // Guardar si no hay errores
        $resultado = $tiendaNota->guardar();

        if ($resultado) {
            header('Location: /admin/notaPedido/crearTienda?id=' . $id_post . '&exito=1');
            exit;
        }

        // Si guardar falla por alguna razón, puedes setear una alerta genérica
        $_SESSION['alertas'] = ['error' => ['No se pudo guardar. Intenta de nuevo.']];
        $_SESSION['old'] = $_POST;
        header('Location: /admin/notaPedido/crearTienda?id=' . $id_post);
        exit;
    }

    // 6) Renderizar vista
    $router->render('admin/notapedido/crearTienda', [
        'titulo' => 'Crear Tienda para Nota de Pedido',
        'nombre' => $nombre,
        'email' => $email,
        'alertas' => $alertas,
        'old' => $old, // para repoblar inputs en la vista si quieres
        'tiendaNota' => $tiendaNota,
        'id_nota_pedido' => $id_nota_pedido,
        'tiendaNotas' => $tiendaNotas,
        'informacionNota' => $informacionNota,
        'tiendas' => $tiendas,
        'ciudad' => $ciudad,
        'paises' => $paises,
        'marca' => $marca,
    ]);
}


    // REGISTRAR UNA NOTA PEDIDO
    public static function RegistrarNotaPedido()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_SESSION['id'];
            $carritoTemporal = Carrito2::wherenuevo('id_usuario', $id_usuario);

            if (empty($carritoTemporal)) {
                header('Location: /carrito');
                exit;
            }

            // Calcular total
            $total = 0;
            foreach ($carritoTemporal as $item) {
                $total += $item->cantidad;
            }

            // Obtener consumo de papel del form
            $etiqueta = $_POST['etiqueta'] ?? 0;
            $prenda = $_POST['prenda'] ?? 0;
            $partida = $_POST['partida'] ?? 0;

            $composicion = $_POST['composicion'] ?? 0;
            $cantidad = $_POST['cantidad'] ?? 0;
            $precio_unitario = $_POST['precio_unitario'] ?? 0;
            $total = $cantidad * $precio_unitario;
            $num_factura = $_POST['num_factura'] ?? '';
            $tienda = $_POST['tienda'] ?? '';
            $marca = $_POST['marca'] ?? '';
            $pais = $_POST['pais'] ?? '';
            $num_caja = $_POST['num_caja'] ?? 0;
            $bodega = $_POST['bodega'] ?? '';
            // fecha manual
            $fecha = $_POST['fecha'] ?? date('Y-m-d');

            // Crear venta
            $venta = new Ventas;
            $venta->total = $total;
            $venta->etiqueta = $etiqueta;
            $venta->prenda = $prenda;
            $venta->partida = $partida;
            $venta->composicion = $composicion;
            $venta->cantidad = $cantidad;
            $venta->precio_unitario = $precio_unitario;
            $venta->num_factura = $num_factura;
            $venta->tienda = $tienda;
            $venta->marca = $marca;
            $venta->pais = $pais;
            $venta->num_caja = $num_caja;
            $venta->bodega = $bodega;


            // $venta->fecha = date('Y-m-d H:i:s');
            $venta->fecha = $fecha;
            $venta->guardarCarrito();

            $id_venta = $venta->id;

            // Insertar detalles
            foreach ($carritoTemporal as $item) {
                $detalle = new DetalleVenta();
                $detalle->id_venta = $id_venta;
                $detalle->Codigo_Nota_Pedido = $item->Codigo_Nota_Pedido;
                $detalle->etiqueta = $item->etiqueta;
                $detalle->prenda = $item->prenda;
                $detalle->partida = $item->partida;
                $detalle->composicion = $item->composicion;
                $detalle->cantidad = $item->cantidad;
                $detalle->precio_unitario = $item->precio_unitario;


                // fecha
                // $detalle->fecha = date('Y-m-d H:i:s');
                $detalle->fecha = $fecha;
                $detalle->guardarCarrito();
            }

            Carrito2::eliminarPorColumna('id_usuario', $id_usuario);

            header('Location: /admin/pruebas/crearPruebas?exito=1');
            exit;
        } else {
            header('Location: /carrito');
            exit;
        }
    }
}
