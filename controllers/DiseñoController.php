<?php

namespace Controllers;

use Classes\EmailDiseno;
use Classes\EmailRegistroDiseno;
use Model\CambiosTurno;
use Model\Diseno;
use Model\TurnoDiseno;
use MVC\Router;

class DiseñoController
{
    public static function crearDiseno(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];
        $diseno = new Diseno;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $diseno->sincronizar($_POST);
            $alertas = $diseno->validar();

            // Verificar si el código ya está registrado antes de subir el archivo
            $existeCodigo = Diseno::where('codigo_producto', $diseno->codigo_producto);
            if ($existeCodigo) {
                Diseno::setAlerta('error', 'El código ya está registrado. No se subió el PDF.');
                $alertas = Diseno::getAlertas();
            } else {
                // Subir el PDF solo si el código no existe
                if (!empty($_FILES['pdf']['tmp_name'])) {
                    $carpeta_pdfs = $_SERVER['DOCUMENT_ROOT'] . '/src/visor';

                    if (!is_dir($carpeta_pdfs)) {
                        mkdir($carpeta_pdfs, 0755, true);
                    }

                    $nombre_pdf = md5(uniqid(rand(), true)) . '.pdf';
                    $ruta_destino = $carpeta_pdfs . '/' . $nombre_pdf;

                    if (move_uploaded_file($_FILES['pdf']['tmp_name'], $ruta_destino)) {
                        $diseno->pdf = $nombre_pdf;
                    } else {
                        $alertas[] = "Error al mover el archivo PDF. Verifica los permisos de la carpeta.";
                    }
                }

                // Guardar si no hay alertas
                if (empty($alertas)) {
                    $resultado = $diseno->guardar();
                    if ($resultado) {
                        header('Location: /admin/diseno/crearDiseno?exito=1');
                        exit;
                    }
                }
            }
        }

        $router->render('admin/diseno/crearDiseno', [
            'titulo' => 'CREAR DISEÑO',
            'nombre' => $nombre,
            'email' => $email,
            'diseno' => $diseno,
            'alertas' => $diseno->getAlertas(),
        ]);
    }


    public static function tablaDiseno(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        // Obtener todos los diseños
        $disenos = Diseno::all();

        $router->render('admin/diseno/tablaDiseno', [
            'titulo' => 'TABLA DISEÑO',
            'subtitulo' => 'Diseños Registrados',
            'nombre' => $nombre,
            'email' => $email,
            'disenos' => $disenos,
        ]);
    }


    public static function editarDiseno(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        // Obtener el ID del diseño a editar
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin/diseno/tablaDiseno');
            exit;
        }

        // Buscar el diseño por ID
        $diseno = Diseno::find($id);
        if (!$diseno) {
            header('Location: /admin/diseno/tablaDiseno');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $diseno->sincronizar($_POST);
            $alertas = $diseno->validar();

            if (!empty($_FILES['pdf']['tmp_name'])) {
                $carpeta_pdfs = $_SERVER['DOCUMENT_ROOT'] . '/src/visor';

                // Crear carpeta si no existe
                if (!is_dir($carpeta_pdfs)) {
                    mkdir($carpeta_pdfs, 0755, true);
                }

                // Generar un nombre único para el archivo 
                $nombre_pdf = md5(uniqid(rand(), true)) . '.pdf';
                $ruta_destino = $carpeta_pdfs . '/' . $nombre_pdf;

                // Intentar mover el archivo cargado
                if (move_uploaded_file($_FILES['pdf']['tmp_name'], $ruta_destino)) {
                    // Asignar el nombre del archivo al objeto diseño
                    $diseno->pdf = $nombre_pdf;
                } else {
                    $alertas[] = "Error al mover el archivo PDF. Verifica los permisos de la carpeta.";
                }

                // debuguear($diseno);
            }

            if (empty($alertas)) {
                // Guardar en la base de datos
                $resultado = $diseno->guardar();
                if ($resultado) {
                    header('Location: /admin/diseno/tablaDiseno?editado=2');
                    exit;
                }
            }
        }

        $router->render('admin/diseno/editarDiseno', [
            'titulo' => 'EDITAR DISEÑO',
            'nombre' => $nombre,
            'email' => $email,
            'diseno' => $diseno,
            'alertas' => $diseno->getAlertas(),
        ]);
    }
    // elimnar pdf 


    public static function eliminarPDF()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            echo json_encode(['error' => 'No autorizado']);
            return;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'ID no proporcionado']);
            return;
        }

        $diseno = Diseno::find($id);
        if (!$diseno || !$diseno->pdf) {
            echo json_encode(['error' => 'Diseño o PDF no encontrado']);
            return;
        }

        $ruta_pdf = $_SERVER['DOCUMENT_ROOT'] . '/src/visor/' . $diseno->pdf;
        if (file_exists($ruta_pdf)) {
            unlink($ruta_pdf);
        }

        $diseno->pdf = null;
        $diseno->guardar();

        echo json_encode(['success' => true]);
    }






    public static function eliminarDiseno()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $diseno = Diseno::find($id);
            if ($diseno) {
                $resultado = $diseno->eliminar();
                if ($resultado) {
                    header('Location: /admin/diseno/tablaDiseno?eliminado=3');
                } else {
                    header('Location: /admin/diseno/tablaDiseno?error=1');
                }
            } else {
                header('Location: /admin/diseno/tablaDiseno?error=1');
            }
        }
    }





    // Generar Turno
    public static function generarTurno(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $alertas = [];
        $turno = new TurnoDiseno;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['colores']) && is_array($_POST['colores'])) {
                $_POST['colores'] = implode(',', $_POST['colores']);
            }

            $turno->sincronizar($_POST);



            // debuguear($turno);

            // generar codigo aleatorio pero solo de 6 digitos
            $turno->codigo = substr(md5(uniqid(rand(), true)), 0, 6);


            if (!empty($_FILES['pdf']['tmp_name'])) {
                $carpeta_archivos = $_SERVER['DOCUMENT_ROOT'] . '/src/turnos';

                if (!is_dir($carpeta_archivos)) {
                    mkdir($carpeta_archivos, 0755, true);
                }

                // Detectar extensión original en minúsculas
                $extension = strtolower(pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION));

                // Extensiones permitidas
                $permitidos = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'ai'];

                if (!in_array($extension, $permitidos)) {
                    $alertas[] = "Formato de archivo no permitido ($extension).";
                    return;
                }

                // Nombre único
                $nombre_archivo = md5(uniqid(rand(), true)) . '.' . $extension;
                $ruta_destino = $carpeta_archivos . '/' . $nombre_archivo;

                // Mover archivo a la carpeta
                if (move_uploaded_file($_FILES['pdf']['tmp_name'], $ruta_destino)) {
                    $turno->pdf = $nombre_archivo;
                } else {
                    $alertas[] = "Error al mover el archivo. Verifica los permisos de la carpeta.";
                }
            }

            //     debuguear($turno);
            // debuguear($turno);
            // email por defecto
            // $emaildefault = 'desarrollodeproductoms@gmail.com';
            $emaildefault = 'sistemas@megaecuador.com';

            // // Enviar correo de confirmación
            $email = new EmailRegistroDiseno(
                $emaildefault,
                $turno->vendedor,
                $turno->codigo,
                $turno->estado,
                $turno->tipo_producto,
                $turno->tipo_componente,
                $turno->alto,
                $turno->largo,
                $turno->ancho,
                $turno->dobles,
                $turno->flauta,
                $turno->material,
                $turno->ect,
                $turno->descripcion,
                $turno->observaciones
            );


            // $emails = ['sistemas@megaecuador.com', 'edwin.ed948@gmail.com'];

            // foreach ($emails as $destinatario) {
            //     $email = new EmailRegistroDiseno(
            //         $destinatario,
            //         $turno->vendedor,
            //         $turno->codigo,
            //         $turno->estado,
            //         $turno->tipo_producto,
            //         $turno->tipo_componente,
            //         $turno->alto,
            //         $turno->largo,
            //         $turno->ancho,
            //         $turno->dobles,
            //         $turno->flauta,
            //         $turno->material,
            //         $turno->ect,
            //         $turno->descripcion,
            //         $turno->observaciones
            //     );

            $email->enviarConfirmacion2();


            // debuguear($turno);
            $alertas = $turno->validar();

            if (empty($alertas)) {
                $resultado = $turno->guardar();
                if ($resultado) {
                    header('Location: /admin/turnoDiseno/generarTurno?exito=1');
                }
            }
        }

        $router->render('admin/turnoDiseno/generarTurno', [
            'titulo' => 'GENERAR TURNO',
            'nombre' => $nombre,
            'email' => $email,
            'alertas' => $alertas,
        ]);
    }



    // turno tablaDiseno
    public static function turnotablaDiseno(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $turnos = TurnoDiseno::all();



        $router->render('admin/turnoDiseno/turnotablaDiseno', [
            'titulo' => 'TABLA TURNO',
            'nombre' => $nombre,
            'email' => $email,
            'turnos' => $turnos,
            'detalle' => $detalle,
        ]);
    }


    // editar turno
    public static function editarTurno(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        $nombre = $_SESSION['nombre'];
        $email  = $_SESSION['email'];
        $alertas = [];

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /admin/turnoDiseno/turnotablaDiseno');
            exit;
        }

        // Cargar el registro existente
        $turno = TurnoDiseno::find($id);

        if (isset($_POST['colores']) && is_array($_POST['colores'])) {
            $_POST['colores'] = implode(',', $_POST['colores']);
        }


        // si turno->estado ==en proceso la posicion deberia ser 0
        if ($turno->estado === 'EN PROCESO' || $turno->estado === 'ENTREGADO') {
            $turno->posicion = 0;
        } else {
            // Obtener la posición del registro según su fecha de creación
            $posicion = TurnoDiseno::countTicketsPendientesHoy($turno->fecha_creacion);
            $turno->posicion = $posicion;
        }




        if (!empty($_FILES['pdf']['tmp_name'])) {
            $carpeta_archivos = $_SERVER['DOCUMENT_ROOT'] . '/src/turnos';

            if (!is_dir($carpeta_archivos)) {
                mkdir($carpeta_archivos, 0755, true);
            }

            // Detectar extensión original en minúsculas
            $extension = strtolower(pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION));

            // Extensiones permitidas
            $permitidos = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'ai'];

            if (!in_array($extension, $permitidos)) {
                $alertas[] = "Formato de archivo no permitido ($extension).";
                return;
            }

            // Nombre único
            $nombre_archivo = md5(uniqid(rand(), true)) . '.' . $extension;
            $ruta_destino = $carpeta_archivos . '/' . $nombre_archivo;

            // Mover archivo a la carpeta
            if (move_uploaded_file($_FILES['pdf']['tmp_name'], $ruta_destino)) {
                $turno->pdf = $nombre_archivo;
            } else {
                $alertas[] = "Error al mover el archivo. Verifica los permisos de la carpeta.";
            }
        }





        // debuguear($turno->posicion);




        // debuguear($turno->colores);

        $coloresSeleccionados = [];
        if (isset($turno->colores) && !empty($turno->colores)) {
            $coloresSeleccionados = explode(',', $turno->colores);
        }


        if (!$turno) {
            header('Location: /admin/turnoDiseno/turnotablaDiseno');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // O usa un método sincronizar si tu ActiveRecord lo tiene
            if (method_exists($turno, 'sincronizar')) {
                $turno->sincronizar($_POST);


                function normalizar($s)
                {
                    $s = trim($s);
                    $s = preg_replace('/\s+/', ' ', $s); // compacta espacios
                    $s = mb_strtoupper($s, 'UTF-8');
                    // elimina tildes comunes
                    $s = strtr($s, [
                        'Á' => 'A',
                        'É' => 'E',
                        'Í' => 'I',
                        'Ó' => 'O',
                        'Ú' => 'U',
                        'Ü' => 'U',
                        'Ñ' => 'N',
                        'á' => 'A',
                        'é' => 'E',
                        'í' => 'I',
                        'ó' => 'O',
                        'ú' => 'U',
                        'ü' => 'U',
                        'ñ' => 'N'
                    ]);
                    return $s;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if (method_exists($turno, 'sincronizar')) {
                        $turno->sincronizar($_POST);
                    }

                    // Solo redirige si el destino original es el correo de pruebas
                    if (isset($email) && strcasecmp(trim($email), 'pruebas@megaecuador.com') === 0 || strcasecmp(trim($email), 'artes@megaecuador.com') === 0) {

                        // Cambia esta variable si tu campo real se llama distinto:
                        $vendedorNombre = $_POST['vendedor'] ?? $nombre;

                        $vendedores = [
                            "JHON VACA"          => "sistemas@megaecuador.com",
                            "SHULYANA HERNANDEZ" => "sistemas@megaecuador.com",
                            "ANTONELLA DEZCALZI" => "sistemas@megaecuador.com",
                            "CAROLINA MUÑOZ"     => "sistemas@megaecuador.com",
                            "CARLOS DELGADO"     => "sistemas@megaecuador.com",
                            "GABRIEL MALDONADO"   => "sistemas@megaecuador.com"
                        ];
                        // $vendedores = [
                        //     "JHON VACA"          => "ventas@megaecuador.com",
                        //     "SHULYANA HERNANDEZ" => "sistemas@megaecuador.com",
                        //     "ANTONELLA DEZCALZI" => "ventas4@megaecuador.com",
                        //     "CAROLINA MUÑOZ"     => "comercial@megaecuador.com",
                        //     "CARLOS DELGADO"     => "ventas1@megaecuador.com",
                        //     "GABRIEL MALDONADO"   => "asistente.ventas@megaecuador.com"
                        // ];

                        // Crea un mapa con claves normalizadas
                        $mapa = [];
                        foreach ($vendedores as $k => $v) {
                            $mapa[normalizar($k)] = $v;
                        }

                        $clave = normalizar($vendedorNombre);
                        $destinatario = $mapa[$clave] ?? null;

                        // (Opcional) Coincidencia difusa si no se encontró exacta
                        if ($destinatario === null) {
                            $mejor = null;
                            $distMejor = PHP_INT_MAX;
                            $mejorClave = null;
                            foreach (array_keys($mapa) as $k) {
                                $d = levenshtein($clave, $k);
                                if ($d < $distMejor) {
                                    $distMejor = $d;
                                    $mejor = $mapa[$k];
                                    $mejorClave = $k;
                                }
                            }
                            if ($distMejor <= 2) { // tolera 1–2 letras de diferencia
                                $destinatario = $mejor;
                                error_log("Usando coincidencia aproximada: '$vendedorNombre' ~ '$mejorClave' (dist=$distMejor)");
                            }
                        }
                        $codigo = $turno->codigo;


                        if ($destinatario === null) {
                            // Si no hay match, manda al correo por defecto (o maneja el error)
                            $destinatario = 'sistemas@megaecuador.com';

                            error_log("Sin coincidencia para vendedor='$vendedorNombre' (clave='$clave').");
                        }

                        // Importante: pasa el OBJETO $turno (tu clase usa $turno->id en el constructor)
                        $mailer = new EmailDiseno(
                            $destinatario,
                            $vendedorNombre,
                            $codigo,
                            $turno->tipo_producto,
                            $turno->tipo_componente,
                            $turno->alto,
                            $turno->largo,
                            $turno->ancho,
                            $turno->dobles,
                            $turno->descripcion,
                            $turno->fecha_creacion,
                            $turno->fecha_entrega,
                            $turno->estado,
                            $turno->posicion
                        );

                        if (!$mailer->enviarConfirmacion()) {
                            error_log('No se pudo enviar el correo de confirmación.');
                        }
                    }
                }
            }

            // Asegurar que el id siga presente
            $turno->id = $id;

            $alertas = $turno->validar();

            if (empty($alertas)) {
                $resultado = $turno->guardar(); // debe hacer UPDATE al tener id
                if ($resultado) {
                    header('Location: /admin/turnoDiseno/turnotablaDiseno?editado=2');
                    exit;
                }
            }
        }

        $router->render('admin/turnoDiseno/editarTurno', [
            'titulo'  => 'EDITAR TURNO',
            'nombre'  => $nombre,
            'email'   => $email,
            'turno'   => $turno,
            'alertas' => $alertas,
            'coloresSeleccionados' => $coloresSeleccionados
        ]);
    }


    // eliminar turno diseño
    public static function eliminarTurnoDiseno(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        $id = $_POST['id'] ?? null;
        if ($id) {
            $turno = TurnoDiseno::find($id);
            if ($turno) {
                $resultado = $turno->eliminar();
                if ($resultado) {
                    header('Location: /admin/turnoDiseno/turnotablaDiseno?eliminado=3');
                } else {
                    header('Location: /admin/turnoDiseno/turnotablaDiseno?error=1');
                }
            } else {
                header('Location: /admin/turnoDiseno/turnotablaDiseno?error=1');
            }
        }
    }


    public static function eliminarPDFturno()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            echo json_encode(['error' => 'No autorizado']);
            return;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'ID no proporcionado']);
            return;
        }

        $turno = TurnoDiseno::find($id);
        if (!$turno || !$turno->pdf) {
            echo json_encode(['error' => 'Turno o PDF no encontrado']);
            return;
        }

        $ruta_pdf = $_SERVER['DOCUMENT_ROOT'] . '/src/turnos/' . $turno->pdf;
        if (file_exists($ruta_pdf)) {
            unlink($ruta_pdf);
        }

        $turno->pdf = null;
        $turno->guardar();

        echo json_encode(['success' => true]);
    }


    // cambios
    // public static function cambios(Router $router)
    // {
    //     session_start();
    //     if (!isset($_SESSION['email'])) {
    //         header('Location: /');
    //         exit;
    //     }
    //     $alertas = [];


    //     $nombre = $_SESSION['nombre'];
    //     $email  = $_SESSION['email'];



    //     $turno = new CambiosTurno;





    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $turno->sincronizar($_POST);


    //         debuguear($turno);

    //     }


    //     $router->render('admin/turnoDiseno/cambios', [
    //         'titulo'  => 'CAMBIOS EN EL PEDIDO',
    //         'nombre'  => $nombre,
    //         'email'   => $email,
    //         'alertas' => $alertas,

    //     ]);
    // }



    public static function cambios(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        $alertas = [];
        $nombre  = $_SESSION['nombre'];
        $email   = $_SESSION['email'];

        $turno = new CambiosTurno;

        // ID de turno original desde URL
        $id_turno = $_GET['id'] ?? null;

        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //     // ID del turno (lo tomamos de la URL o del POST si lo mandas como hidden)
        //     $turno->id_turno = $_POST['id_turno'] ?? $id_turno;
        //    debuguear($turno);

        //     $turno->sincronizar($_POST);

        //     // Validar que el turno existe
        //     $datos = TurnoDiseno::find($turno->id_turno);
        //     if(!$datos) {
        //         $alertas[] = "El turno no existe.";
        //     } else {
        //         // Sincronizar con datos del formulario

        //         // Forzar campos que queremos asegurar
        //         $turno->id_turno = $id_turno;
        //         $turno->codigo   = $datos->codigo ?? '';

        //         // Guardar como nuevo registro
        //         $turno->guardar();

        //         // Redirigir con mensaje de éxito
        //         header("Location: /admin/turnoDiseno/cambios?exito=1");
        //         exit;
        //     }
        // }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Tomar el id de una sola fuente confiable
            $idTurno = $_POST['id_turno'] ?? ($id_turno ?? null);
            if (!$idTurno) {
                $alertas[] = "Falta id_turno.";
            } else {

                // 1) Volcar datos del formulario
                $turno->sincronizar($_POST);

                // 2) Asegurar el id_turno DESPUÉS de sincronizar
                $turno->id_turno = (int)$idTurno;
                // tomar la hora actual
                $turno->fecha_creacion = date('Y-m-d H:i:s');

                // 3) Validar turno origen
                $datos = TurnoDiseno::find($turno->id_turno);
                if (!$datos) {
                    $alertas[] = "El turno no existe.";
                } else {
                    // 4) Forzar campos que dependan del turno válido
                    $turno->codigo = $datos->codigo ?? null;

                    // 5) Guardar
                    $turno->guardar();

                    // 6) Redirigir
                    header("Location: /admin/turnoDiseno/turnotablaDiseno?exito=1");
                    exit;
                }
            }
        }




        $router->render('admin/turnoDiseno/cambios', [
            'titulo'   => 'CAMBIOS EN EL PEDIDO',
            'nombre'   => $nombre,
            'email'    => $email,
            'alertas'  => $alertas,
            'turno'    => $turno,
            'id_turno' => $id_turno
        ]);
    }

    // EDITARCAMBIOS
    public static function editarCambios(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
            exit;
        }

        $alertas = [];
        $nombre  = $_SESSION['nombre'];
        $email   = $_SESSION['email'];

        // $turno = new CambiosTurno;

        // ID de turno original desde URL
        $id = $_GET['id'] ?? null;
        $id = filter_var($id, FILTER_VALIDATE_INT);



        $turno = CambiosTurno::find($id);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            unset($data['id_turno']); // <- lo sacas antes
            $turno->sincronizar($data);

            // $turno->sincronizar($_POST);
            $alertas = $turno->validar();

            if (empty($alertas)) {
                $resultado = $turno->guardar(); // debe hacer UPDATE al tener id
                if ($resultado) {
                    header('Location: /admin/turnoDiseno/turnotablaDiseno?editado=2');
                    exit;
                }
            }
        }


        $router->render('admin/turnoDiseno/editarCambios', [
            'titulo'   => 'EDITAR CAMBIOS EN EL PEDIDO',
            'nombre'   => $nombre,
            'email'    => $email,
            'alertas'  => $alertas,
            'turno'    => $turno,
            // 'id_turno' => $id_turno
        ]);
    }
}
