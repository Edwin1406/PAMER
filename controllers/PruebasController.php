<?php

namespace Controllers;

use Model\Bodega;
use Model\Carrito;
use Model\Carrito2;
use Model\Ciudad;
use Model\Compra;
use Model\DetalleVenta;
use Model\Marca;
use Model\NotaPedido;
use Model\Pais;
use Model\Prenda;
use Model\Tienda;
use Model\TiendaNota;
use Model\Ventas;
use MVC\Router;
use TCPDF;

class PruebasController
{

    // public static function crearPruebas(Router $router)
    // {
    //     session_start();
    //     if (!isset($_SESSION['email'])) {
    //         header('Location: /');
    //         exit;
    //     }

    //     // id_nota puede venir por GET o por POST
    //     $id_nota = $_GET['id'] ?? ($_POST['id_nota'] ?? null);
    //     if (!$id_nota) {
    //         header('Location: /admin/notaPedido/crearNota');
    //         exit;
    //     }

    //     // Catálogos
    //     $tiendas = Tienda::all();
    //     $bodega  = Bodega::all();
    //     $ciudad  = Ciudad::all();
    //     $pais    = Pais::all();
    //     $marca   = Marca::all();

    //     // Info de la nota
    //     $informacionNota = NotaPedido::where('Codigo_Nota_Pedido', $id_nota);
    //     $fecha = NotaPedido::where('Codigo_Nota_Pedido', $id_nota)->Fecha_Nota_Pedido ?? date('Y-m-d');

    //     // Datos de sesión
    //     $nombre = $_SESSION['nombre'];
    //     $email  = $_SESSION['email'];

    //     // Auxiliares
    //     $carritoTemporal = Carrito::all();
    //     $carrito = new Carrito;
    //     $alertas = [];

    //     // 1) Recuperar “old” de sesión (flash) si vienes de un redirect
    //     $old = $_SESSION['old'] ?? [];
    //     if (isset($_SESSION['old'])) {
    //         unset($_SESSION['old']); // flash: se usa una vez
    //     }

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         // 2) Guardar lo recibido como “old”
    //         $old = $_POST;

    //         // Mapear POST al modelo
    //         $carrito->Codigo_Nota_Pedido       = $id_nota;
    //         $carrito->Nombre_Tienda            = $_POST['Nombre_Tienda'] ?? '';
    //         $carrito->Fecha_Tienda_Nota_Pedido = $_POST['Fecha_Tienda_Nota_Pedido'] ?? null;
    //         $carrito->Factura_Nota_Pedido      = $_POST['Factura_Nota_Pedido'] ?? null;
    //         $carrito->Total_Tienda_Nota_Pedido = $_POST['Total_Tienda_Nota_Pedido'] ?? 0.00;
    //         $carrito->cantidad                 = $_POST['cantidad'] ?? 0;

    //         // Validación del modelo
    //         $alertas = $carrito->validar();

    //         if (empty($alertas)) {
    //             $resultado = $carrito->guardar();
    //             if ($resultado) {
    //                 // 3) Guardar “old” en sesión antes del redirect
    //                 $_SESSION['old'] = $old;
    //                 header("Location: /admin/pruebas/crearPruebas?id=$id_nota&exito=1");
    //                 exit;
    //             } else {
    //                 $alertas['error'][] = 'Error al guardar el registro';
    //             }
    //         }
    //         // Si hay errores, seguimos al render con $old ya cargado
    //     }

    //     // Renderizar la vista
    //     $router->render('admin/pruebas/crearPruebas', [
    //         'titulo'          => 'Crear Pruebas',
    //         'alertas'         => $alertas,
    //         'nombre'          => $nombre,
    //         'email'           => $email,
    //         'carritoTemporal' => $carritoTemporal,
    //         'id_nota'         => $id_nota,
    //         'informacionNota' => $informacionNota,
    //         'fecha'           => $fecha,
    //         'tiendas'         => $tiendas,
    //         'bodega'          => $bodega,
    //         'ciudad'          => $ciudad,
    //         'pais'            => $pais,
    //         'marca'           => $marca,
    //         'old'             => $old,
    //     ]);
    // }

    public static function crearPruebas(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        // id_nota puede venir por GET o por POST
        // $id_nota = $_GET['id'] ?? ($_POST['id_nota'] ?? null);
        // if (!$id_nota) {
        //     header('Location: /admin/notaPedido/crearNota');
        //     exit;
        // }



        $id_tienda_nota = $_GET['id'] ?? null;

        //  if (!$id_tienda_nota) {
        //     header('Location: /admin/notaPedido/crearNota');
        //     exit;
        // }



        // debuguear($id_tienda_nota);

        // obtener el id_nota a partir del id_tienda_nota
        $id_nota = TiendaNota::where('id', $id_tienda_nota)->Codigo_Nota_Pedido ?? null;


        // obtengo la información de la tienda nota
        // $informacionNota = TiendaNota::where('id', $id_tienda_nota);
        // debuguear($informacionNota);


        // debuguear($id_nota);









        // Detectar si el cliente quiere JSON (AJAX)
        $isAjax      = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        $acceptsJson = isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json');
        $wantsJson   = $isAjax || $acceptsJson;

        // Catálogos (como los tenías)
        $tiendas = Tienda::all();
        $bodega  = Bodega::all();
        $ciudad  = Ciudad::all();
        $paises    = Pais::all();
        $marca   = Marca::all();
        $prendas = Prenda::all();



        // debuguear($paises);

        // Info de la nota (como lo tenías)
        $informacionNota = NotaPedido::where('Codigo_Nota_Pedido', $id_nota);


        //tienda_nota
        $tienda_nota = TiendaNota::where('id', $id_tienda_nota);

        $fecha = NotaPedido::where('Codigo_Nota_Pedido', $id_nota)->Fecha_Nota_Pedido ?? date('Y-m-d');

        // Datos de sesión
        $nombre = $_SESSION['nombre'];
        $email  = $_SESSION['email'];

        // Datos existentes para pintar en la vista
        $carritoTemporal2 = Carrito2::all('ASC');

        $carrito = new Carrito2;
        $alertas = [];

        // Flash "old" si vienes de redirect
        $old = $_SESSION['old'] ?? [];
        if (isset($_SESSION['old'])) {
            unset($_SESSION['old']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Guardar "old" para el flujo con redirect
            $old = $_POST;

            // Mapear POST -> modelo (solo los campos pedidos)
            // $carrito->Codigo_Nota_Pedido = $id_nota;  

            $id_tienda = $_POST['id_tienda'] ?? null;

            // debuguear($id_tienda);


            $id_nota = $_POST['id_nota'] ?? 0;

            $carrito->Codigo_Nota_Pedido = $id_nota;
            $carrito->etiqueta           = $_POST['etiqueta']   ?? 0;
            $carrito->prenda             = $_POST['Prenda_Partida']   ?? '';
            $carrito->saldo              = $_POST['saldo']   ?? 0;
            $carrito->composicion        = $_POST['composicion']   ?? '';
            $carrito->cantidad           = $_POST['cantidad'] ?? 0;
            $carrito->precio_unitario    = $_POST['precio_unitario'] ?? 0;
            // $carrito->total              = $_POST['total'] ?? 0;
            $carrito->total              = (float)($carrito->cantidad * $carrito->precio_unitario);
            $carrito->num_factura        = $_POST['num_factura'] ?? 0;
            $carrito->tienda             = $_POST['tienda'] ?? '';
            $carrito->marca              = $_POST['marca'] ?? '';
            $carrito->pais               = $_POST['pais'] ?? '';
            $carrito->num_caja           = $_POST['num_caja'] ?? 0;
            $carrito->bodega             = $_POST['bodega'] ?? '';
            $carrito->id_tienda          = $id_tienda ?? null;


            // Saneos mínimos
            $carrito->prenda   = trim((string)$carrito->prenda);
            $carrito->cantidad = is_numeric($carrito->cantidad) ? (float)$carrito->cantidad : 0.0;

            // Validación del modelo (usa tu Carrito2::validar())

            // debuguear($carrito);




            $alertas = $carrito->validar();


            // debuguear($carrito);

            if (empty($alertas)) {
                $ok = $carrito->guardar();

                if ($ok) {
                    // Rama AJAX/JSON: devolver JSON y NO redirigir
                    if ($wantsJson) {
                        header('Content-Type: application/json');
                        echo json_encode([
                            'ok'  => true,
                            'id'  => $carrito->id ?? null,
                            'row' => [
                                'id'                  => $carrito->id ?? null,
                                // nombres que usa el frontend en Handsontable
                                'codigo_nota_pedido'  => $carrito->Codigo_Nota_Pedido,
                                'etiqueta'            => $carrito->etiqueta,
                                'prenda'              => $carrito->prenda,
                                'saldo'               => $carrito->saldo,
                                'composicion'         => $carrito->composicion,
                                'cantidad'            => (float)$carrito->cantidad,
                                'precio_unitario'     => number_format((float)$carrito->precio_unitario, 2, '.', ''),
                                'total'               => number_format((float)$carrito->total, 2, '.', ''),
                                'num_factura'         => $carrito->num_factura,
                                'tienda'              => $carrito->tienda,
                                'marca'               => $carrito->marca,
                                'pais'                => $carrito->pais,
                                'num_caja'            => $carrito->num_caja,
                                'bodega'              => $carrito->bodega,
                                'id_tienda'           => $carrito->id_tienda,

                            ],
                        ], JSON_UNESCAPED_UNICODE);
                        exit;
                    }

                    // Rama FORM tradicional: redirect como siempre
                    $_SESSION['old'] = $old;

                    header("Location: /admin/pruebas/crearPruebas?id=$id_tienda&exito=1");

                    // cargo de nuevo la página para evitar reenvío de formulario





                    exit;
                } else {
                    $alertas['error'][] = 'Error al guardar el registro';
                }
            }

            // Si viene por AJAX y hay errores -> 422 con JSON
            if ($wantsJson) {
                http_response_code(422);
                header('Content-Type: application/json');
                echo json_encode([
                    'ok'     => false,
                    'errors' => $alertas,
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }
            // Si es FORM y hay errores: continuar al render mostrando alertas
        }

        // Renderizar la vista
        $router->render('admin/pruebas/crearPruebas', [
            'titulo'            => 'Crear Pruebas',
            'alertas'           => $alertas,
            'nombre'            => $nombre,
            'email'             => $email,
            'carritoTemporal2'  => $carritoTemporal2,
            'id_nota'           => $id_nota,
            'informacionNota'   => $informacionNota,
            'fecha'             => $fecha,
            'tiendas'           => $tiendas,
            'bodega'            => $bodega,
            'ciudad'            => $ciudad,
            'paises'            => $paises,
            'marca'             => $marca,
            'old'               => $old,
            'prendas'           => $prendas,
            'tienda_nota'      => $tienda_nota,
        ]);
    }



    public static function crearPrenda()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            http_response_code(401);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'No autorizado']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'Método no permitido']);
            return;
        }

        // Campos (mismos nombres)
        $prenda = new Prenda;
        $prenda->Prenda_Partida      = trim($_POST['Prenda_Partida'] ?? '');
        $prenda->Partida_Partida     = trim($_POST['Partida_Partida'] ?? '');
        $prenda->Composicion_Partida = trim($_POST['Composicion_Partida'] ?? '');

        // Validación mínima
        if ($prenda->Prenda_Partida === '') {
            http_response_code(422);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'El campo "Prenda" es obligatorio.']);
            return;
        }

        // Guardar
        $ok = $prenda->guardar(); // ideal: setea $prenda->id o retorna el ID
        if (!$ok) {
            http_response_code(500);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'No se pudo guardar.']);
            return;
        }

        // Respuesta JSON simple
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'ok' => true,
            'prenda' => [
                'id'                  => $prenda->id ?? null,
                'Prenda_Partida'      => $prenda->Prenda_Partida,
                'Partida_Partida'     => $prenda->Partida_Partida,
                'Composicion_Partida' => $prenda->Composicion_Partida,
            ],
        ], JSON_UNESCAPED_UNICODE);
    }










    public static function eliminarCarrito()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        $id_nota = $_GET['id'] ?? ($_POST['id_nota'] ?? null);

        // AJAX/JSON
        $isAjax      = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        $acceptsJson = isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json');
        $wantsJson   = $isAjax || $acceptsJson;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $carrito = $id ? Carrito2::find($id) : null;

            if ($carrito) {
                $carrito->eliminar();

                if ($wantsJson) {
                    header('Content-Type: application/json');
                    echo json_encode(['ok' => true], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                header("Location: /admin/pruebas/crearPruebas?id=$id_nota&eliminado=3");
                exit;
            } else {
                if ($wantsJson) {
                    http_response_code(404);
                    header('Content-Type: application/json');
                    echo json_encode(['ok' => false, 'error' => 'Registro no encontrado'], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                header("Location: /admin/pruebas/crearPruebas?id=$id_nota&error=1");
                exit;
            }
        }

        // No-POST
        if ($wantsJson) {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['ok' => false, 'error' => 'Method not allowed'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        header("Location: /admin/pruebas/crearPruebas?id=$id_nota&error=1");
        exit;
    }




    public static function actualizarPruebas()
    {
        session_start();
        header('Content-Type: application/json');

        if (!isset($_SESSION['email'])) {
            echo json_encode(['ok' => false, 'error' => 'no-auth']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['ok' => false, 'error' => 'bad-method']);
            return;
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0) {
            echo json_encode(['ok' => false, 'error' => 'missing-id']);
            return;
        }

        $carrito = Carrito2::find($id);
        if (!$carrito) {
            echo json_encode(['ok' => false, 'error' => 'not-found']);
            return;
        }

        // Datos
        $idNota      = $_POST['id_nota'] ?? null;
        $etiqueta    = trim($_POST['etiqueta'] ?? '');
        $prenda      = trim($_POST['prenda'] ?? '');
        // cantidad - eitqueta es saldo
        $saldo     = (float)($_POST['cantidad'] ?? 0) - (float)($_POST['etiqueta'] ?? 0);
        $composicion = trim($_POST['composicion'] ?? '');
        $cantidad    = (float)($_POST['cantidad'] ?? 0);
        $precioU     = (float)($_POST['precio_unitario'] ?? 0);
        $total       = (float)($cantidad * $precioU);
        $num_factura = ($_POST['num_factura'] ?? 0);
        $tienda      = trim($_POST['tienda'] ?? '');
        $marca       = trim($_POST['marca'] ?? '');
        $pais        = trim($_POST['pais'] ?? '');
        $num_caja    = ($_POST['num_caja'] ?? 0);
        $bodega      = trim($_POST['bodega'] ?? '');
        $id_tienda   = isset($_POST['id_tienda']) ? (int)$_POST['id_tienda'] : null;

        // Actualizar
        $carrito->Codigo_Nota_Pedido = $idNota ?: $carrito->Codigo_Nota_Pedido;
        $carrito->etiqueta           = $etiqueta;
        $carrito->prenda             = $prenda;
        $carrito->saldo              = $saldo;
        $carrito->composicion        = $composicion;
        $carrito->cantidad           = $cantidad;
        $carrito->precio_unitario    = $precioU;
        $carrito->total              = $total;
        $carrito->num_factura        = $num_factura;
        $carrito->tienda             = $tienda;
        $carrito->marca              = $marca;
        $carrito->pais               = $pais;
        $carrito->num_caja           = $num_caja;
        $carrito->bodega             = $bodega;
        $carrito->id_tienda          = $id_tienda;

        $ok = $carrito->guardar();
        echo json_encode(['ok' => (bool)$ok, 'id' => $carrito->id]);
    }



    public static function crearPruebasAjax()
    {
        session_start();
        header('Content-Type: application/json; charset=utf-8');

        if (!isset($_SESSION['email'])) {
            echo json_encode(['ok' => false, 'error' => 'no-auth'], JSON_UNESCAPED_UNICODE);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['ok' => false, 'error' => 'bad-method'], JSON_UNESCAPED_UNICODE);
            return;
        }

        // --------- Inputs ----------
        $idNota    = $_POST['id_nota'] ?? null;
        $id_tienda = isset($_POST['id_tienda']) ? (int)$_POST['id_tienda'] : 0;

        $etiqueta  = trim((string)($_POST['etiqueta'] ?? ''));
        $prenda    = trim((string)($_POST['prenda'] ?? ''));
        $cantidad  = (float)($_POST['cantidad'] ?? 0);
        $precioU   = (float)($_POST['precio_unitario'] ?? 0);

        // ✅ Solo evita filas vacías (basura)
        $isEmpty = ($etiqueta === '' && $prenda === '' && $cantidad == 0 && $precioU == 0);

        if (!$idNota || $id_tienda <= 0 || $isEmpty) {
            echo json_encode(['ok' => false, 'error' => 'empty-or-missing'], JSON_UNESCAPED_UNICODE);
            return;
        }

        // --------- Modelo ----------
        $carrito = new Carrito2();

        $carrito->Codigo_Nota_Pedido = $idNota;
        $carrito->id_tienda          = $id_tienda;

        $carrito->etiqueta           = $etiqueta;
        $carrito->prenda             = $prenda;

        // ✅ saldo NO debe restar etiqueta (texto). Ajusta si tu negocio requiere otra lógica.
        // Por defecto lo dejamos igual a la cantidad (o usa 0 si aplica)
        $carrito->saldo              = $cantidad;

        $carrito->composicion        = trim((string)($_POST['composicion'] ?? ''));
        $carrito->cantidad           = $cantidad;
        $carrito->precio_unitario    = $precioU;
        $carrito->total              = (float)($cantidad * $precioU);

        // Otros campos
        $carrito->num_factura        = trim((string)($_POST['num_factura'] ?? ''));
        $carrito->tienda             = trim((string)($_POST['tienda'] ?? ''));
        $carrito->marca              = trim((string)($_POST['marca'] ?? ''));
        $carrito->pais               = trim((string)($_POST['pais'] ?? ''));
        $carrito->num_caja           = (int)($_POST['num_caja'] ?? 0);
        $carrito->bodega             = trim((string)($_POST['bodega'] ?? ''));

        // --------- Validación ----------
        $alertas = $carrito->validar();
        if (!empty($alertas)) {
            http_response_code(422);
            echo json_encode(['ok' => false, 'errors' => $alertas], JSON_UNESCAPED_UNICODE);
            return;
        }

        // --------- Duplicado: SOLO si TODOS los campos coinciden ----------
        // Incluye Codigo_Nota_Pedido para que NO compare contra otras notas.
        $duplicados = Carrito2::whereArray([
            'Codigo_Nota_Pedido' => $carrito->Codigo_Nota_Pedido,
            'id_tienda'          => $carrito->id_tienda,
            'etiqueta'           => $carrito->etiqueta,
            'prenda'             => $carrito->prenda,
            'composicion'        => $carrito->composicion,
            'cantidad'           => $carrito->cantidad,
            'precio_unitario'    => $carrito->precio_unitario,
            'num_caja'           => $carrito->num_caja,
            'bodega'             => $carrito->bodega,
            // Si quieres que tienda/marca/pais también cuenten como “idéntico”, descomenta:
            'tienda'          => $carrito->tienda,
            'marca'           => $carrito->marca,
            'pais'            => $carrito->pais,
            'num_factura'     => $carrito->num_factura,
        ]);

        // ✅ Si existe IDENTICO → NO guardar
        if (!empty($duplicados)) {
            echo json_encode(['ok' => false, 'error' => 'duplicate-row'], JSON_UNESCAPED_UNICODE);
            return;
        }

        // ✅ Si NO existe → guardar
        $ok = $carrito->guardar();

        if (!$ok) {
            echo json_encode(['ok' => false, 'error' => 'db-save-failed'], JSON_UNESCAPED_UNICODE);
            return;
        }

        echo json_encode(['ok' => true, 'id' => $carrito->id], JSON_UNESCAPED_UNICODE);
    }


















    public static function registrarVenta()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // $id_usuario = $_SESSION['id'];
            // $carritoTemporal = Carrito2::wherenuevo('id_usuario', $id_usuario);

            // debuguear($carritoTemporal);

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
            $via_trasporte = $_POST['via_trasporte'] ?? 0;
            $puerto_embarque = $_POST['puerto_embarque'] ?? 0;
            $puerto_destino = $_POST['puerto_destino'] ?? 0;
            $Fob_Nota_Pedido = $_POST['Fob_Nota_Pedido'] ?? 0;
            $Flete_Nota_Pedido = $_POST['Flete_Nota_Pedido'] ?? 0;
            $Costo_Flete_Nota_Pedido = $_POST['Costo_Flete_Nota_Pedido'] ?? 0;
            $Seguro_Nota_Pedido = $_POST['Seguro_Nota_Pedido'] ?? 0;





            // fecha manual
            $fecha = $_POST['fecha'] ?? date('Y-m-d');

            // Crear venta
            $venta = new Compra;
            // $venta->id_usuario = $id_usuario;
            $venta->Total_Nota_Pedido = $total;
            $venta->via_trasporte = $_POST['via_trasporte'];
            $venta->puerto_embarque = $_POST['puerto_embarque'];
            $venta->puerto_destino = $_POST['puerto_destino'];
            $venta->Fob_Nota_Pedido = $Fob_Nota_Pedido;
            $venta->Flete_Nota_Pedido = $Flete_Nota_Pedido;
            $venta->Costo_Flete_Nota_Pedido = $Costo_Flete_Nota_Pedido;
            $venta->Seguro_Nota_Pedido = $Seguro_Nota_Pedido;


            // $venta->fecha = date('Y-m-d H:i:s');
            $venta->fecha = $fecha;
            $venta->guardarCarrito();

            $id_venta = $venta->id;

            // Insertar detalles
            foreach ($carritoTemporal as $item) {
                $detalle = new DetalleVenta;
                $detalle->id_venta = $id_venta;
                $detalle->tipo_maquina = $item->tipo_maquina;
                $detalle->cantidad = $item->cantidad;
                $detalle->casos = $item->casos;
                $detalle->observaciones = $item->observaciones;

                // fecha
                // $detalle->fecha = date('Y-m-d H:i:s');
                $detalle->fecha = $fecha;
                $detalle->guardarCarrito();
            }

            // Carrito::eliminarPorColumna('id_usuario', $id_usuario);

            header('Location: /admin/pruebas/crearPruebas?exito=1');
            exit;
        } else {
            header('Location: /carrito');
            exit;
        }
    }



    // public static function pdf(Router $router)
    // {
    //     session_start();
    //     if (!isset($_SESSION['email'])) {
    //         header('Location: /');
    //         exit;
    //     }

    //     $id_nota = $_GET['id'] ?? null;
    //     if (!$id_nota) {
    //         http_response_code(400);
    //         echo "Falta el id de la nota";
    //         exit;
    //     }

    //     // Si tu TCPDF no está por composer, descomenta y ajusta:
    //     // require_once __DIR__ . '/../tcpdf/tcpdf.php';

    //     $nota  = NotaPedido::where('Codigo_Nota_Pedido', $id_nota);
    //     $items = Carrito2::whereArray(['Codigo_Nota_Pedido' => $id_nota]);

    //     if (!$nota) {
    //         http_response_code(404);
    //         echo "No existe la nota {$id_nota}";
    //         exit;
    //     }

    //     // ====== PDF ======
    //     $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

    //     // Info documento
    //     $pdf->SetCreator('Sistema');
    //     $pdf->SetAuthor('Importadora');
    //     $pdf->SetTitle("Nota de Pedido {$id_nota}");

    //     // Márgenes + saltos
    //     $pdf->SetMargins(10, 10, 10);
    //     $pdf->SetAutoPageBreak(true, 12);

    //     // Quitar header/footer por defecto de TCPDF (para que no estorbe)
    //     $pdf->setPrintHeader(false);
    //     $pdf->setPrintFooter(false);

    //     $pdf->AddPage();

    //     // ====== HEADER BONITO (Logo + Título + Línea) ======
    //     self::renderHeader($pdf, $nota);

    //     // ====== BLOQUE DATOS (2 columnas alineadas) ======
    //     self::renderMetaBox($pdf, $nota);

    //     // ====== TABLA ITEMS + TOTAL ======
    //     self::renderItemsTable($pdf, $items);

    //     // Mostrar en navegador (I) o descargar (D)
    //     $pdf->Output("nota_pedido_{$id_nota}.pdf", 'I');
    //     exit;
    // }

    // private static function renderHeader(TCPDF $pdf, $nota): void
    // {
    //     // Línea superior (tipo documento)
    //     $pdf->SetDrawColor(0, 0, 0);
    //     $pdf->Line(10, 10, 287, 10);

    //     // Logo (izquierda)
    //     // AJUSTA ESTA RUTA:
    //     $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/src/img/PAMERVAL-LOGO.png'; // ejemplo: public/img/logo.png
    //     if (file_exists($logoPath)) {
    //         // x=10 y=12 w=58mm
    //         $pdf->Image($logoPath, 20, 12, 58, 0, '', '', '', false, 300);
    //     }

    //     // Título centrado
    //     $pdf->SetY(12);
    //     $pdf->SetFont('helvetica', 'B', 16);
    //     $pdf->Cell(0, 8, 'Importadora R M y Cia.', 0, 1, 'C');

    //     $pdf->SetFont('helvetica', '', 10);
    //     $pdf->Cell(0, 6, 'NOTA DE PEDIDO: ' . (string)$nota->Codigo_Nota_Pedido, 0, 1, 'C');

    //     // Línea inferior del encabezado
    //     $pdf->Ln(1);
    //     $pdf->Line(10, $pdf->GetY(), 287, $pdf->GetY());
    //     $pdf->Ln(4);
    // }

    // private static function renderMetaBox(TCPDF $pdf, $nota): void
    // {
    //     $leftW  = 190;
    //     $rightW = 90;
    //     $rowH   = 6;

    //     $pdf->SetDrawColor(0, 0, 0);
    //     $pdf->SetFillColor(245, 245, 245);

    //     // Títulos de sección
    //     $pdf->SetFont('helvetica', 'B', 9);
    //     $pdf->Cell($leftW, 7, 'Datos principales', 1, 0, 'L', true);
    //     $pdf->Cell($rightW, 7, 'Información', 1, 1, 'L', true);

    //     $pdf->SetFont('helvetica', '', 9);

    //     $pdf->Cell($leftW, $rowH, 'Importador: ' . (string)$nota->Codigo_Importador, 1, 0, 'L');
    //     $pdf->Cell($rightW, $rowH, 'Fecha: ' . (string)$nota->Fecha_Nota_Pedido, 1, 1, 'L');

    //     $pdf->Cell($leftW, $rowH, 'Exportador: ' . (string)$nota->Codigo_Exportador, 1, 0, 'L');
    //     $pdf->Cell($rightW, $rowH, 'País / Origen: ' . (string)$nota->Pais_Nota_Pedido, 1, 1, 'L');

    //     $pdf->Cell($leftW, $rowH, 'Remitir documentos a: ' . (string)$nota->Remitir_Nota_Pedido, 1, 0, 'L');
    //     $pdf->Cell($rightW, $rowH, 'Forma de pago: ' . (string)$nota->Forma_Pago_Nota_Pedido, 1, 1, 'L');

    //     $pdf->Cell($leftW, $rowH, 'Moneda: ' . (string)$nota->Moneda_Nota_Pedido, 1, 0, 'L');
    //     $pdf->Cell($rightW, $rowH, 'Número Nota: ' . (string)$nota->Numero_Nota_Pedido, 1, 1, 'L');

    //     $pdf->Ln(6);
    // }

    // private static function renderItemsTable(TCPDF $pdf, array $items): void
    // {
    //     // Anchos de columnas (suma aprox. <= 277)
    //     $w = [
    //         'etq'   => 12,
    //         'sald'  => 14,
    //         'prenda'=> 34,
    //         'comp'  => 52,
    //         'cant'  => 16,
    //         'punit' => 22,
    //         'total' => 22,
    //         'fact'  => 28,
    //         'marca' => 24,
    //         'orig'  => 22,
    //     ];

    //     $pdf->SetDrawColor(0, 0, 0);

    //     // Header tabla
    //     $pdf->SetFont('helvetica', 'B', 9);
    //     $pdf->SetFillColor(230, 230, 230);

    //     $pdf->Cell($w['etq'], 7, 'ETQ', 1, 0, 'C', true);
    //     $pdf->Cell($w['sald'], 7, 'SALD', 1, 0, 'C', true);
    //     $pdf->Cell($w['prenda'], 7, 'PRENDA', 1, 0, 'C', true);
    //     $pdf->Cell($w['comp'], 7, 'COMPOSICIÓN', 1, 0, 'C', true);
    //     $pdf->Cell($w['cant'], 7, 'CANT', 1, 0, 'C', true);
    //     $pdf->Cell($w['punit'], 7, 'P. UNIT', 1, 0, 'C', true);
    //     $pdf->Cell($w['total'], 7, 'TOTAL', 1, 0, 'C', true);
    //     $pdf->Cell($w['fact'], 7, 'FACTURA', 1, 0, 'C', true);
    //     $pdf->Cell($w['marca'], 7, 'MARCA', 1, 0, 'C', true);
    //     $pdf->Cell($w['orig'], 7, 'ORIGEN', 1, 0, 'C', true);
    //     $pdf->Cell($w['caja'], 7, 'CAJA', 1, 1, 'C', true);

    //     $pdf->SetFont('helvetica', '', 9);

    //     $totalGeneral = 0.0;

    //     foreach ($items as $it) {
    //         // Si vienen como objetos, funciona igual:
    //         $etq   = $it->etiqueta ?? '';
    //         $sald  = $it->saldo ?? '';
    //         $prend = $it->prenda ?? '';
    //         $comp  = $it->composicion ?? '';
    //         $cant  = $it->cantidad ?? 0;
    //         $punit = (float)($it->precio_unitario ?? 0);
    //         $tot   = (float)($it->total ?? ($punit * (float)$cant));
    //         $fact  = $it->num_factura ?? '';
    //         $marca = $it->marca ?? '';
    //         $orig  = $it->pais ?? '';
    //         $caja  = $it->caja ?? '';
    //         $totalGeneral += $tot;

    //         // filas
    //         $pdf->Cell($w['etq'], 6, (string)$etq, 1, 0, 'C');
    //         $pdf->Cell($w['sald'], 6, (string)$sald, 1, 0, 'C');
    //         $pdf->Cell($w['prenda'], 6, (string)$prend, 1, 0, 'L');

    //         // MultiCell para composición si es larga (manteniendo alineación)
    //         $x = $pdf->GetX();
    //         $y = $pdf->GetY();
    //         $pdf->MultiCell($w['comp'], 6, (string)$comp, 1, 'L', false, 0, '', '', true, 0, false, true, 6, 'M');

    //         $pdf->Cell($w['cant'], 6, (string)$cant, 1, 0, 'C'); 
    //         $pdf->Cell($w['punit'], 6, number_format($punit, 2, '.', ''), 1, 0, 'R');
    //         $pdf->Cell($w['total'], 6, number_format($tot, 2, '.', ''), 1, 0, 'R');
    //         $pdf->Cell($w['fact'], 6, (string)$fact, 1, 0, 'C');
    //         $pdf->Cell($w['marca'], 6, (string)$marca, 1, 0, 'C');
    //         $pdf->Cell($w['orig'], 6, (string)$orig, 1, 0, 'C');
    //         $pdf->Cell($w['caja'], 6, (string)$caja, 1, 1, 'C');
    //     }

    //     // Total general
    //     $pdf->Ln(2);
    //     $pdf->SetFont('helvetica', 'B', 10);
    //     $pdf->SetFillColor(245,245,245);

    //     $tableWidth = array_sum($w);
    //     $labelW = $tableWidth - 30;

    //     $pdf->Cell($labelW, 8, 'TOTAL GENERAL:', 1, 0, 'R', true);
    //     $pdf->Cell(30, 8, number_format($totalGeneral, 2, '.', ''), 1, 1, 'R', true);
    // }


    public static function pdf(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        $id_nota = $_GET['id'] ?? null;
        if (!$id_nota) {
            http_response_code(400);
            echo "Falta el id de la nota";
            exit;
        }

        $nota  = NotaPedido::where('Codigo_Nota_Pedido', $id_nota);
        $items = Carrito2::whereArray(['Codigo_Nota_Pedido' => $id_nota]);

        if (!$nota) {
            http_response_code(404);
            echo "No existe la nota {$id_nota}";
            exit;
        }

        // ====== PDF VERTICAL ======
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator('Sistema');
        $pdf->SetAuthor('Importadora');
        $pdf->SetTitle("Nota de Pedido {$id_nota}");

        $pdf->SetMargins(10, 10, 10);
        $pdf->SetAutoPageBreak(true, 12);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        self::renderHeader($pdf, $nota);
        self::renderMetaBox($pdf, $nota);
        self::renderItemsTable($pdf, $items);

        $pdf->Output("nota_pedido_{$id_nota}.pdf", 'I');
        exit;
    }

    private static function renderHeader(TCPDF $pdf, $nota): void
    {
        // Ancho útil en A4 vertical con márgenes 10/10 => 210 - 20 = 190
        $xLeft  = 10;
        $xRight = 200; // 10 + 190

        // Línea superior
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->Line($xLeft, 10, $xRight, 10);

        // Logo (izq)
        $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/src/img/PAMERVAL-LOGO.png'; // AJUSTA
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 20, 12, 48, 0, '', '', '', false, 300);
        }

        // Título centrado
        $pdf->SetY(12);
        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->Cell(0, 7, 'Importadora R M y Cia.', 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 6, 'NOTA DE PEDIDO: ' . (string)$nota->Codigo_Nota_Pedido, 0, 1, 'C');

        // Línea inferior
        $pdf->Ln(1);
        $pdf->Line($xLeft, $pdf->GetY(), $xRight, $pdf->GetY());
        $pdf->Ln(4);
    }

    private static function renderMetaBox(TCPDF $pdf, $nota): void
    {
        // En vertical: 190mm ancho útil. Divide 120 + 70
        $leftW  = 120;
        $rightW = 70;
        $rowH   = 6;

        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(245, 245, 245);

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell($leftW, 7, 'Datos principales', 1, 0, 'L', true);
        $pdf->Cell($rightW, 7, 'Información', 1, 1, 'L', true);

        $pdf->SetFont('helvetica', '', 9);

        $pdf->Cell($leftW, $rowH, 'Importador: ' . (string)$nota->Codigo_Importador, 1, 0, 'L');
        $pdf->Cell($rightW, $rowH, 'Fecha: ' . (string)$nota->Fecha_Nota_Pedido, 1, 1, 'L');

        $pdf->Cell($leftW, $rowH, 'Exportador: ' . (string)$nota->Codigo_Exportador, 1, 0, 'L');
        $pdf->Cell($rightW, $rowH, 'País / Origen: ' . (string)$nota->Pais_Nota_Pedido, 1, 1, 'L');

        $pdf->Cell($leftW, $rowH, 'Remitir documentos a: ' . (string)$nota->Remitir_Nota_Pedido, 1, 0, 'L');
        $pdf->Cell($rightW, $rowH, 'Forma de pago: ' . (string)$nota->Forma_Pago_Nota_Pedido, 1, 1, 'L');

        $pdf->Cell($leftW, $rowH, 'Moneda: ' . (string)$nota->Moneda_Nota_Pedido, 1, 0, 'L');
        $pdf->Cell($rightW, $rowH, 'Número Nota: ' . (string)$nota->Numero_Nota_Pedido, 1, 1, 'L');

        $pdf->Ln(6);
    }

    private static function renderItemsTable(TCPDF $pdf, array $items): void
    {
        // Ajustado a 190mm total (A4 vertical con márgenes 10/10)
        // Suma = 190
        $w = [
            'etq'   => 10,
            'sald'  => 12,
            'prenda' => 20,
            'comp'  => 25,
            'cant'  => 12,
            'punit' => 18,
            'total' => 18,
            'fact'  => 22,
            'marca' => 16,
            'orig'  => 18,
            'caja'  => 16,
        ];

        $pdf->SetDrawColor(0, 0, 0);

        // Header tabla
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetFillColor(230, 230, 230);

        $pdf->Cell($w['etq'], 7, 'ETQ', 1, 0, 'C', true);
        $pdf->Cell($w['sald'], 7, 'SALD', 1, 0, 'C', true);
        $pdf->Cell($w['prenda'], 7, 'PRENDA', 1, 0, 'C', true);
        $pdf->Cell($w['comp'], 7, 'COMPOSICIÓN', 1, 0, 'C', true);
        $pdf->Cell($w['cant'], 7, 'CANT', 1, 0, 'C', true);
        $pdf->Cell($w['punit'], 7, 'P. UNIT', 1, 0, 'C', true);
        $pdf->Cell($w['total'], 7, 'TOTAL', 1, 0, 'C', true);
        $pdf->Cell($w['fact'], 7, 'FACTURA', 1, 0, 'C', true);
        $pdf->Cell($w['marca'], 7, 'MARCA', 1, 0, 'C', true);
        $pdf->Cell($w['orig'], 7, 'ORIGEN', 1, 0, 'C', true);
        $pdf->Cell($w['caja'], 7, 'CAJA', 1, 1, 'C', true);

        $pdf->SetFont('helvetica', '', 9);

        $totalGeneral = 0.0;

        foreach ($items as $it) {
            $etq   = $it->etiqueta ?? '';
            $sald  = $it->saldo ?? '';
            $prend = $it->prenda ?? '';
            $comp  = $it->composicion ?? '';
            $cant  = $it->cantidad ?? 0;
            $punit = (float)($it->precio_unitario ?? 0);
            $tot   = (float)($it->total ?? ($punit * (float)$cant));
            $fact  = $it->num_factura ?? '';
            $marca = $it->marca ?? '';
            $orig  = $it->pais ?? '';
            $caja  = $it->num_caja ?? '';
            $totalGeneral += $tot;

            $pdf->Cell($w['etq'], 6, (string)$etq, 1, 0, 'C');
            $pdf->Cell($w['sald'], 6, (string)$sald, 1, 0, 'C');
            $pdf->Cell($w['prenda'], 6, (string)$prend, 1, 0, 'L');

            // Composición con MultiCell (sin romper fila)
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $pdf->MultiCell($w['comp'], 6, (string)$comp, 1, 'L', false, 0, '', '', true, 0, false, true, 6, 'M');

            $pdf->Cell($w['cant'], 6, (string)$cant, 1, 0, 'C');
            $pdf->Cell($w['punit'], 6, number_format($punit, 2, '.', ''), 1, 0, 'R');
            $pdf->Cell($w['total'], 6, number_format($tot, 2, '.', ''), 1, 0, 'R');
            $pdf->Cell($w['fact'], 6, (string)$fact, 1, 0, 'C');
            $pdf->Cell($w['marca'], 6, (string)$marca, 1, 0, 'C');
            $pdf->Cell($w['orig'], 6, (string)$orig, 1, 0, 'C');
            $pdf->Cell($w['caja'], 6, (string)$caja, 1, 1, 'C');
        }

        // Total general
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetFillColor(245, 245, 245);

        $tableWidth = array_sum($w); // 190
        $labelW = $tableWidth - 30;

        $pdf->Cell($labelW, 8, 'TOTAL GENERAL:', 1, 0, 'R', true);
        $pdf->Cell(30, 8, number_format($totalGeneral, 2, '.', ''), 1, 1, 'R', true);
    }
}
