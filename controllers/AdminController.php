<?php

namespace Controllers;


use Model\Consumo_general;
use Model\HorasTrabajo;
use Model\Prueba;
use MVC\Router;


class AdminController
{
    public static function index(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }
        $usuariosConectados = self::contarUsuariosConectados();

        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];
        // debuguear($nombre);
        $router->render('admin/dashboard/index', [
            'titulo' => 'MEGASTOCK-DESARROLLO',
            'nombre' => $nombre,
            'email' => $email,
            'usuariosConectados' => $usuariosConectados
        ]);
    }


    // hora de trabajo

    public static function horasTrabajo(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $horas_trabajo = new HorasTrabajo;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $horas_trabajo->sincronizar($_POST);

            // debuguear($horas_trabajo);
            $alertas = $horas_trabajo->validar();
            if (empty($alertas)) {
                $horas_trabajo->guardar();
                header('Location: /admin/consumo?exito=1');
            }
        }
    }









    // consumo
    public static function consumo(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }
        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];
        //cerrar sesión
        // solo que me aparezca la hora que fue registrada en la fecha actual de hoy
        $fecha_hoy = date('Y-m-d');



        $alertas = [];
        $consumo = new Prueba();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['personal']) && is_array($_POST['personal'])) {
                $_POST['personal'] = implode(',', $_POST['personal']);
            }

            $consumo->sincronizar($_POST);

            // sacar total de horas.
            $consumo->sacarTotalHoras();


            // Calcular productividad cada 15 minutos
            // $cantidad = is_numeric($consumo->cantidad) ? (float)$consumo->cantidad : 0;
            // $minutos_trabajados = $consumo->total_horas * 60;

            // if ($cantidad > 0 && $minutos_trabajados > 0) {
            //     // $control->x_hora = ($cantidad / $minutos_trabajados) * 15;
            //     $consumo->x_hora = round(($cantidad / $minutos_trabajados) * 60);
            // } else {
            //     $consumo->x_hora = 0;
            // }



            // // Calcular productividad por hora
            $cantidad = is_numeric($consumo->cantidad) ? (float)$consumo->cantidad : 0;
            $total_horas = is_numeric($consumo->total_horas) ? (float)$consumo->total_horas : 0;

            if ($cantidad > 0 && $total_horas > 0) {
                $consumo->x_hora = round($cantidad / $total_horas);
            } else {
                $consumo->x_hora = 0;
            }


            // // Calcular productividad por hora
            // $cantidad = is_numeric($consumo->cantidad) ? (float)$consumo->cantidad : 0;
            // $total_horas = is_numeric($consumo->total_horas) ? (float)$consumo->total_horas : 0;

            // if ($cantidad > 0 && $total_horas > 0) {
            //     $consumo->x_hora = $cantidad / $total_horas; // mantiene todos los decimales
            // } else {
            //     $consumo->x_hora = 0;
            // }



            // DEBUGUEAR($consumo); // Para ver los datos que se envían
            $alertas = $consumo->validar();
            if (empty($alertas)) {
                $consumo->guardar();
                // header('Location: /admin/consumo');
                header('Location: /admin/consumo?exito=1');
            }
        } else {
            $alertas = [];
        }

        $router->render('admin/consumo/consumo', [
            'titulo' => 'MEGASTOCK-DESARROLLO',
            'alertas' => $alertas,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }



    // tabla de consumo
    public static function tablaConsumo(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }
        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $consumos = Prueba::all();
        // debuguear($consumos);

        $router->render('admin/consumo/tablaConsumo', [
            'titulo' => 'MEGASTOCK-DESARROLLO',
            'subtitulo' => 'TABLA CONSUMO EMPAQUE',
            'nombre' => $nombre,
            'email' => $email,
            'consumos' => $consumos
        ]);
    }


    // Eliminar consumo
    public static function eliminarConsumo(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $consumo = Prueba::find($id);
                if ($consumo) {
                    $consumo->eliminar();
                    header('Location: /admin/tablaConsumo?exito=1');
                } else {
                    header('Location: /admin/tablaConsumo?error=1');
                }
            } else {
                header('Location: /admin/tablaConsumo?error=1');
            }
        }
    }





    // CONSUMO GENERAL
    public static function consumo_general(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }
        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];
        $consumo_general = new Consumo_general;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipo_maquina = $_POST['tipo_maquina'] ?? '';
            $consumo_general->sincronizar($_POST);
            // debuguear($consumo_general); 
            $alertas = $consumo_general->validar();

            if (empty($alertas)) {
                $consumo_general->guardar();
                header('Location: /admin/consumo_general?exito=1');
            }
        } else {
            $alertas = [];
        }

        $router->render('admin/consumo/consumo_general', [
            'titulo' => 'MEGASTOCK-DESARROLLO',
            'nombre' => $nombre,
            'email' => $email,

        ]);
    }


    // TABLA CONSUMO GENERAL


    public static function tablaConsumoGeneral(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }
        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $consumosGenerales = Consumo_general::all();
        // debuguear($consumosGenerales);

        $router->render('admin/consumo/tablaConsumoGeneral', [
            'titulo' => 'MEGASTOCK-DESARROLLO',
            'nombre' => $nombre,
            'email' => $email,
            'consumosGenerales' => $consumosGenerales
        ]);
    }



    // ELIMINAR CONSUMO GENERAL
    public static function eliminarConsumoGeneral(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if ($id) {
                $consumoGeneral = Consumo_general::find($id);
                if ($consumoGeneral) {
                    $consumoGeneral->eliminar();
                    header('Location: /admin/tablaConsumoGeneral?exito=1');
                } else {
                    header('Location: /admin/tablaConsumoGeneral?error=1');
                }
            } else {
                header('Location: /admin/tablaConsumoGeneral?error=1');
            }
        }
    }




    public static function tablaAdminConsumoGeneral(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }
        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $consumosGenerales = Consumo_general::all();
        // debuguear($consumosGenerales);

        $router->render('admin/consumo/tablaAdminConsumoGeneral', [
            'titulo' => 'MEGASTOCK-DESARROLLO',
            'subtitulo' => 'TABLA ADMIN CONSUMO GENERAL',
            'nombre' => $nombre,
            'email' => $email,
            'consumosGenerales' => $consumosGenerales
        ]);
    }




    // EDITAR CONSUMO GENERAL
    public static function editarAdminConsumoGeneral(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/tablaAdminConsumoGeneral?error=1');
        }

        // debuguear($id);


        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $alertas = [];
        $consumoGeneral = Consumo_general::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $consumoGeneral->sincronizar($_POST);
            // sin espacio en blanco
            $consumoGeneral->tipo_maquina = trim($consumoGeneral->tipo_maquina);
            // debuguear($consumoGeneral);
            $alertas = $consumoGeneral->validar();

            if (empty($alertas)) {
                $consumoGeneral->guardar();
                header('Location: /admin/tablaAdminConsumoGeneral?editado=3');
            }
        } else {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $consumoGeneral = Consumo_general::find($id);
                if (!$consumoGeneral) {
                    header('Location: /admin/tablaAdminConsumoGeneral?error=1');
                }
            } else {
                header('Location: /admin/tablaAdminConsumoGeneral?error=1');
            }
        }

        $router->render('admin/consumo/editarAdminConsumoGeneral', [
            'titulo' => 'MEGASTOCK-DESARROLLO',
            'alertas' => $alertas,
            'nombre' => $nombre,
            'email' => $email,
            'consumoGeneral' => $consumoGeneral
        ]);
    }





    private static function contarUsuariosConectados()
    {
        $path = ini_get("session.save_path");
        if (empty($path)) $path = sys_get_temp_dir();

        $cuenta = 0;
        foreach (glob("$path/sess_*") as $file) {
            if (filemtime($file) + ini_get("session.gc_maxlifetime") > time()) {
                $cuenta++;
            }
        }
        return $cuenta;
    }




    // EDITAR CONSUMO GENERAL
    public static function editarConsumoGeneral(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/tablaConsumoGeneral?error=1');
        }

        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $alertas = [];
        $consumoGeneral = Consumo_general::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $consumoGeneral->sincronizar($_POST);
            // sin espacio en blanco
            $consumoGeneral->tipo_maquina = trim($consumoGeneral->tipo_maquina);
            $alertas = $consumoGeneral->validar();

            if (empty($alertas)) {
                $consumoGeneral->guardar();
                header('Location: /admin/tablaConsumoGeneral?editado=3');
            }
        } else {
            $id = $_GET['id'] ?? null;
            if ($id) {
                $consumoGeneral = Consumo_general::find($id);
                if (!$consumoGeneral) {
                    header('Location: /admin/tablaConsumoGeneral?error=1');
                }
            } else {
                header('Location: /admin/tablaConsumoGeneral?error=1');
            }
        }

        $router->render('admin/consumo/editarConsumoGeneral', [
            'titulo' => 'MEGASTOCK-DESARROLLO',
            'alertas' => $alertas,
            'nombre' => $nombre,
            'email' => $email,
            'consumoGeneral' => $consumoGeneral
        ]);
    }




    // error 404
    public static function error404(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }
        $router->render('admin/error404', [
            'titulo' => 'MEGASTOCK-DESARROLLO',
            'error' => 'Página no encontrada'
        ]);
    }


    // En AdminController.php
    public static function verLogs()
    {
        $archivo = __DIR__ . "/../logs/requests.log";

        $lineas = [];
        if (file_exists($archivo)) {
            $lineas = array_reverse(file($archivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        }

        include __DIR__ . "/../views/admin/logs.php";
    }
}
