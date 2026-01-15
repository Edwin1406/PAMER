<?php

namespace Controllers;

use Model\ControlConvertidor;
use Model\ControlDoblado;
use Model\ControlGuillotina;
use Model\ControlTroquel;
use MVC\Router;

class ControlController
{
    public static function control_troquel(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $control = new ControlTroquel;
        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $control->sincronizar($_POST);
            // debuguear($control);
            if ($control->horas_programadas > 0) {
                // Convertir solo para el cálculo
                $horasDecimal = $control->convertirHorasADecimal($control->horas_programadas);

                if ($horasDecimal > 0) {
                    $control->golpes_maquina_hora = $control->golpes_maquina / $horasDecimal;
                } else {
                    $control->golpes_maquina_hora = 0;
                }
            } else {
                $control->golpes_maquina_hora = 0;
            }

            // debuguear($control);

            $alertas = $control->validar();
            if (empty($alertas)) {
                $resultado = $control->guardar();
                if ($resultado) {
                    header('Location: /admin/control_troquel?exito=1');
                }
            }
        } else {
            $alertas = [];
        }

        $router->render('admin/control/control_troquel', [
            'titulo' => 'Control Troquel',
            'nombre' => $nombre,
            'email' => $email,
            'alertas' => $alertas
        ]);
    }


    // tabla consumo troquel
    public static function tablaConsumoTroquel(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $control = ControlTroquel::all();


        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $router->render('admin/control/tablaConsumoTroquel', [
            'titulo' => 'Tabla Consumo Troquel',
            'subtitulo' => 'Consumo Troquel',
            'nombre' => $nombre,
            'email' => $email,
            'control' => $control
        ]);
    }




    // eliminar consumo troquel
    public static function eliminarConsumoTroquel()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $control = ControlTroquel::find($id);
            if ($control) {
                $resultado = $control->eliminar();
                if ($resultado) {
                    header('Location: /admin/tablaConsumoTroquel?exito=1');
                } else {
                    header('Location: /admin/tablaConsumoTroquel?error=1');
                }
            } else {
                header('Location: /admin/tablaConsumoTroquel?error=1');
            }
        }
    }




    // --------------------------------------------------------------------CONTROL DOBLADO--------------------------------------------



    public static function consumo_doblado(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $alertas = []; // Inicializar para asegurar que esté definida siempre
        $control_doblado = new ControlDoblado;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Convertir 'personal' a string si es un array
            if (isset($_POST['personal']) && is_array($_POST['personal'])) {
                $_POST['personal'] = implode(',', $_POST['personal']);
            }

            // Sincronizar datos
            $control_doblado->sincronizar($_POST);

            // Calcular cantidad_lamina_hora si hay horas programadas
            if ($control_doblado->horas_programadas > 0) {
                $horasDecimal = $control_doblado->convertirHorasADecimal($control_doblado->horas_programadas);

                if ($horasDecimal > 0) {
                    $control_doblado->cantidad_lamina_hora = $control_doblado->cantidad_laminas / $horasDecimal;
                } else {
                    $control_doblado->cantidad_lamina_hora = 0;
                }
            } else {
                $control_doblado->cantidad_lamina_hora = 0;
            }

            // Validar datos
            $alertas = $control_doblado->validar();

            // Si no hay alertas, guardar y redirigir
            if (empty($alertas)) {
                $resultado = $control_doblado->guardar();
                if ($resultado) {
                    header('Location: /admin/control/doblado/consumo_doblado?exito=1');
                    exit;
                }
            }
            // Si hay alertas, se conservarán para mostrarlas en la vista
        }

        // Renderizar vista
        $router->render('admin/control/doblado/consumo_doblado', [
            'titulo' => 'Control Doblado',
            'nombre' => $nombre,
            'email' => $email,
            'alertas' => $alertas
        ]);
    }




    // tabla consumo doblado
    public static function tablaConsumoDoblado(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $control_doblado = ControlDoblado::all();

        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $router->render('admin/control/doblado/tablaConsumoDoblado', [
            'titulo' => 'Tabla Consumo Doblado',
            'subtitulo' => 'Consumo Doblado',
            'nombre' => $nombre,
            'email' => $email,
            'control_doblado' => $control_doblado
        ]);
    }


    // eliminar consumo doblado
    public static function eliminarConsumoDoblado()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $control_doblado = ControlDoblado::find($id);
            if ($control_doblado) {
                $resultado = $control_doblado->eliminar();
                if ($resultado) {
                    header('Location: /admin/control/doblado/tablaConsumoDoblado?exito=1');
                } else {
                    header('Location: /admin/control/doblado/tablaConsumoDoblado?error=1');
                }
            } else {
                header('Location: /admin/control/doblado/tablaConsumoDoblado?error=1');
            }
        }
    }




    // ---------------------------------------- CONTROL CONVERTIDOR ----------------------------------------

    public static function consumo_convertidor(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];
        $alertas = [];


        $control_convertidor = new ControlConvertidor;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $control_convertidor->sincronizar($_POST);

            // debuguear($control_convertidor);

            if ($control_convertidor->horas_programadas > 0) {
                // Convertir solo para el cálculo
                $horasDecimal = $control_convertidor->convertirHorasADecimal($control_convertidor->horas_programadas);

                // Validar que el resultado de conversión sea mayor a 0
                if ($horasDecimal > 0) {
                    $control_convertidor->cantidad_resmas_hora = $control_convertidor->cantidad_resmas / $horasDecimal;
                } else {
                    $control_convertidor->cantidad_resmas_hora = 0;
                }
            } else {
                $control_convertidor->cantidad_resmas_hora = 0;
            }

            // debuguear($control_convertidor);
            $alertas = $control_convertidor->validar();

            if (empty($alertas)) {
                $resultado = $control_convertidor->guardar();
                if ($resultado) {
                    header('Location: /admin/control/convertidor/consumo_convertidor?exito=1');
                }
            } else {
                $alertas = ControlConvertidor::getAlertas();
            }
        }


        $router->render('admin/control/convertidor/consumo_convertidor', [
            'titulo' => 'Control Convertidor',
            'nombre' => $nombre,
            'email' => $email,
            'alertas' => $alertas
        ]);
    }




    // tabla consumo convertidor
    public static function tablaConsumoConvertidor(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $control_convertidor = ControlConvertidor::all();

        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $router->render('admin/control/convertidor/tablaConsumoConvertidor', [
            'titulo' => 'Tabla Consumo Convertidor',
            'subtitulo' => 'Consumo Convertidor',
            'nombre' => $nombre,
            'email' => $email,
            'control_convertidor' => $control_convertidor
        ]);
    }



    // eliminar consumo convertidor
    public static function eliminarConsumoConvertidor()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $control_convertidor = ControlConvertidor::find($id);
            if ($control_convertidor) {
                $resultado = $control_convertidor->eliminar();
                if ($resultado) {
                    header('Location: /admin/control/convertidor/tablaConsumoConvertidor?exito=1');
                } else {
                    header('Location: /admin/control/convertidor/tablaConsumoConvertidor?error=1');
                }
            } else {
                header('Location: /admin/control/convertidor/tablaConsumoConvertidor?error=1');
            }
        }
    }





    // ------------------------------------------ CONSUMO GUILLOTINA PAPEL ----------------------------------------


    public static function consumo_guillotina_papel(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $alertas = []; // Inicializar alertas
        $control_guillotina = new ControlGuillotina;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sincronizar datos del formulario
            $control_guillotina->sincronizar($_POST);

            // Calcular cortes por hora si hay horas programadas
            if ($control_guillotina->horas_programadas > 0) {
                $horasDecimal = $control_guillotina->convertirHorasADecimal($control_guillotina->horas_programadas);

                if ($horasDecimal > 0) {
                    $control_guillotina->n_cortes_hora = $control_guillotina->n_cortes / $horasDecimal;
                } else {
                    $control_guillotina->n_cortes_hora = 0;
                }
            } else {
                $control_guillotina->n_cortes_hora = 0;
            }

            // Validar los datos
            $alertas = $control_guillotina->validar();

            // Si no hay alertas, guardar y redirigir
            if (empty($alertas)) {
                $resultado = $control_guillotina->guardar();
                if ($resultado) {
                    header('Location: /admin/control/guillotina/consumo_guillotina_papel?exito=1');
                    exit;
                }
            }
            // Si hay alertas, se mostrarán en la vista (NO se sobrescriben)
        }

        // Renderizar vista con los datos y alertas
        $router->render('admin/control/guillotina/consumo_guillotina_papel', [
            'titulo' => 'Control Guillotina Papel',
            'nombre' => $nombre,
            'email' => $email,
            'alertas' => $alertas
        ]);
    }



    // tabla consumo guillotina papel
    public static function tablaConsumoGuillotinaPapel(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }
        $alertas = [];

        $control_guillotina = ControlGuillotina::all();

        // NOMBRE DE LA PERSONA LOGEADA
        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $router->render('admin/control/guillotina/tablaConsumoGuillotinaPapel', [
            'titulo' => 'Tabla Consumo Guillotina Papel',
            'subtitulo' => 'Consumo Guillotina Papel',
            'nombre' => $nombre,
            'email' => $email,
            'control_guillotina' => $control_guillotina,
            'alertas' => $alertas
        ]);
    }




    // eliminar consumo guillotina papel
    public static function eliminarConsumoGuillotina()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $control_guillotina = ControlGuillotina::find($id);
            if ($control_guillotina) {
                $resultado = $control_guillotina->eliminar();
                if ($resultado) {
                    header('Location: /admin/control/guillotina/tablaConsumoGuillotinaPapel?exito=1');
                } else {
                    header('Location: /admin/control/guillotina/tablaConsumoGuillotinaPapel?error=1');
                }
            } else {
                header('Location: /admin/control/guillotina/tablaConsumoGuillotinaPapel?error=1');
            }
        }
    }
}
