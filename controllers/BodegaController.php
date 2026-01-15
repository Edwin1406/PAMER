<?php

namespace Controllers;

use Model\Bodega;
use Model\Ciudad;
use Model\Marca;
use Model\Pais;
use Model\Tienda;
use MVC\Router;

class BodegaController
{
    public static function crearBodega(Router $router): void
    {

        $alertas = [];

        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $bodega = new Bodega($_POST);

        // $bodega =  Bodega::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $bodega->sincronizar($_POST);

            // debuguear($bodega);
            $alertas = $bodega->validar();

            if (empty($alertas)) {
                // Guardar el registro
                $resultado = $bodega->guardar();

                if ($resultado) {
                    header('Location: /admin/bodega/tablaBodega?exito=1');
                }
            }
        }

        // Render a la vista
        $router->render('admin/bodega/crearBodega', [
            'titulo' => 'Crea una Bodega',
            'alertas' => $alertas,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }

    // tabla de bodega


    public static function tablaBodega(Router $router): void
    {

        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $bodega =  Bodega::all();

        // Render a la vista
        $router->render('admin/bodega/tablaBodega', [
            'titulo' => 'Tabla de Bodegas',
            'bodega' => $bodega,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }


    public static function eliminarBodega(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar el ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $bodega = Bodega::find($id);
                if ($bodega) {
                    $bodega->eliminar();
                    header('Location: /admin/bodega/tablaBodega?eliminado=3');
                }
            }
        }
    }



    public static function editarBodega(Router $router): void
    {

        $alertas = [];
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        // Validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/bodega/tablaBodega');
        }

        // Obtener los datos de la bodega a editar
        $bodega = Bodega::find($id);

        if (!$bodega) {
            header('Location: /admin/bodega/tablaBodega');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $bodega->sincronizar($_POST);

            // debuguear($bodega);
            $alertas = $bodega->validar();

            if (empty($alertas)) {
                // Guardar el registro
                $resultado = $bodega->guardar();

                if ($resultado) {
                    header('Location: /admin/bodega/tablaBodega?editado=2');
                }
            }
        }

        // Render a la vista
        $router->render('admin/bodega/editarBodega', [
            'titulo' => 'Editar Bodega',
            'alertas' => $alertas,
            'bodega' => $bodega,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }




    // crear ciudad
    public static function crearCiudad(Router $router): void
    {

        $alertas = [];

        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $ciudad = new Ciudad;

        // $bodega =  Bodega::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $ciudad->sincronizar($_POST);

            // debuguear($ciudad);
            $alertas = $ciudad->validar();

            if (empty($alertas)) {
                // Guardar el registro
                $resultado = $ciudad->guardar();

                if ($resultado) {
                    header('Location: /admin/ciudad/tablaCiudad?exito=1');
                }
            }
        }

        // Render a la vista
        $router->render('admin/ciudad/crearCiudad', [
            'titulo' => 'Crea una Ciudad',
            'alertas' => $alertas,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }



    // tabla de ciudad
    public static function tablaCiudad(Router $router): void
    {

        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $ciudad =  Ciudad::all();

        // Render a la vista
        $router->render('admin/ciudad/tablaCiudad', [
            'titulo' => 'Tabla de Ciudades',
            'ciudad' => $ciudad,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }



    public static function eliminarCiudad(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar el ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $ciudad = Ciudad::find($id);
                if ($ciudad) {
                    $ciudad->eliminar();
                    header('Location: /admin/ciudad/tablaCiudad?eliminado=3');
                }
            }
        }
    }


    // editar ciudad
    public static function editarCiudad(Router $router): void
    {

        $alertas = [];
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        // Validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/ciudad/tablaCiudad');
        }

        // Obtener los datos de la ciudad a editar
        $ciudad = Ciudad::find($id);

        if (!$ciudad) {
            header('Location: /admin/ciudad/tablaCiudad');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $ciudad->sincronizar($_POST);

            // debuguear($ciudad);
            $alertas = $ciudad->validar();

            if (empty($alertas)) {
                // Guardar el registro
                $resultado = $ciudad->guardar();

                if ($resultado) {
                    header('Location: /admin/ciudad/tablaCiudad?editado=2');
                }
            }
        }

        // Render a la vista
        $router->render('admin/ciudad/editarCiudad', [
            'titulo' => 'Editar Ciudad',
            'alertas' => $alertas,
            'ciudad' => $ciudad,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }


















    // crear marca
    public static function crearMarca(Router $router): void
    {

        $alertas = [];

        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $marca = new Marca;

        // $bodega =  Bodega::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $marca->sincronizar($_POST);

            // debuguear($marca);
            $alertas = $marca->validar();

            if (empty($alertas)) {
                // Guardar el registro
                $resultado = $marca->guardar();

                if ($resultado) {
                    header('Location: /admin/marca/tablaMarca?exito=1');
                }
            }
        }

        // Render a la vista
        $router->render('admin/marca/crearMarca', [
            'titulo' => 'Crea una Marca',
            'alertas' => $alertas,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }



    // tabla de marca
    public static function tablaMarca(Router $router): void
    {

        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $marca =  Marca::all();

        // Render a la vista
        $router->render('admin/marca/tablaMarca', [
            'titulo' => 'Tabla de Marcas',
            'marca' => $marca,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }


    // eliminar marca
    public static function eliminarMarca(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar el ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $marca = Marca::find($id);
                if ($marca) {
                    $marca->eliminar();
                    header('Location: /admin/marca/tablaMarca?eliminado=3');
                }
            }
        }
    }

    // editar marca
    public static function editarMarca(Router $router): void
    {

        $alertas = [];
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        // Validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/marca/tablaMarca');
        }

        // Obtener los datos de la marca a editar
        $marca = Marca::find($id);

        if (!$marca) {
            header('Location: /admin/marca/tablaMarca');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $marca->sincronizar($_POST);

            // debuguear($marca);
            $alertas = $marca->validar();

            if (empty($alertas)) {
                // Guardar el registro
                $resultado = $marca->guardar();

                if ($resultado) {
                    header('Location: /admin/marca/tablaMarca?editado=2');
                }
            }
        }

        // Render a la vista
        $router->render('admin/marca/editarMarca', [
            'titulo' => 'Editar Marca',
            'alertas' => $alertas,
            'marca' => $marca,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }




    // crear origen
    public static function crearPais(Router $router): void
    {

        $alertas = [];

        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $pais = new Pais;

        // $bodega =  Bodega::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $pais->sincronizar($_POST);

            // debuguear($pais);
            $alertas = $pais->validar();

            if (empty($alertas)) {
                // Guardar el registro
                $resultado = $pais->guardar();

                if ($resultado) {
                    header('Location: /admin/paises/tablaPais?exito=1');
                }
            }
        }

        // Render a la vista
        $router->render('admin/paises/crearPais', [
            'titulo' => 'Crea un Pais',
            'alertas' => $alertas,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }


    // tabla de pais
    public static function tablaPais(Router $router): void
    {

        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $pais =  Pais::all();


        // debuguear($pais);

        // Render a la vista
        $router->render('admin/paises/tablaPais', [
            'titulo' => 'Tabla de Paises',
            'subtitulo' => 'Listado de Paises',
            'pais' => $pais,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }


    // eliminar pais
    public static function eliminarPais(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validar el ID
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $pais = Pais::find($id);
                if ($pais) {
                    $pais->eliminar();
                    header('Location: /admin/paises/tablaPais?eliminado=3');
                }
            }
        }
    }


    // editar pais
    public static function editarPais(Router $router): void
    {

        $alertas = [];
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        // Validar el ID
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/paises/tablaPais');
        }

        // Obtener los datos de la pais a editar
        $pais = Pais::find($id);

        if (!$pais) {
            header('Location: /admin/paises/tablaPais');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $pais->sincronizar($_POST);

            // debuguear($pais);
            $alertas = $pais->validar();

            if (empty($alertas)) {
                // Guardar el registro
                $resultado = $pais->guardar();

                if ($resultado) {
                    header('Location: /admin/paises/tablaPais?editado=2');
                }
            }
        }

        // Render a la vista
        $router->render('admin/paises/editarPais', [
            'titulo' => 'Editar Pais',
            'alertas' => $alertas,
            'pais' => $pais,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }


    // crear Tienda
    public static function crearTienda(Router $router): void
    {
        $alertas = [];
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email  = $_SESSION['email'];

        $bodega = Bodega::all();
        $ciudad = Ciudad::all();

        $tienda = new Tienda;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tienda->sincronizar($_POST);

        


            // === Archivo ===
            if (!empty($_FILES['Foto_Tienda']['tmp_name'])) {
                $file = $_FILES['Foto_Tienda'];
                $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

                $carpeta_archivos = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/src/tiendas';
                if (!is_dir($carpeta_archivos)) {
                    mkdir($carpeta_archivos, 0755, true);
                }

                if (in_array($extension, $permitidos)) {
                    // Tamaño deseado
                    $ancho_final = 800;
                    $alto_final  = 600;

                    // Crear imagen desde el archivo original
                    switch ($extension) {
                        case 'jpg':
                        case 'jpeg':
                            $origen = imagecreatefromjpeg($file['tmp_name']);
                            break;
                        case 'png':
                            $origen = imagecreatefrompng($file['tmp_name']);
                            break;
                        case 'gif':
                            $origen = imagecreatefromgif($file['tmp_name']);
                            break;
                        default:
                            $origen = null;
                    }

                    if ($origen) {
                        $ancho_orig = imagesx($origen);
                        $alto_orig  = imagesy($origen);

                        // Crear lienzo con nuevas dimensiones
                        $imagen_redimensionada = imagecreatetruecolor($ancho_final, $alto_final);

                        // Mantener transparencia en PNG/GIF
                        if ($extension === 'png' || $extension === 'gif') {
                            imagecolortransparent(
                                $imagen_redimensionada,
                                imagecolorallocatealpha($imagen_redimensionada, 0, 0, 0, 127)
                            );
                            imagealphablending($imagen_redimensionada, false);
                            imagesavealpha($imagen_redimensionada, true);
                        }

                        // Redimensionar
                        imagecopyresampled(
                            $imagen_redimensionada,
                            $origen,
                            0,
                            0,
                            0,
                            0,
                            $ancho_final,
                            $alto_final,
                            $ancho_orig,
                            $alto_orig
                        );

                        // Nombre único (hash)
                        $nombre_archivo = bin2hex(random_bytes(16)) . '.' . $extension;
                        $ruta_destino   = $carpeta_archivos . '/' . $nombre_archivo;

                        // Guardar según tipo
                        switch ($extension) {
                            case 'jpg':
                            case 'jpeg':
                                imagejpeg($imagen_redimensionada, $ruta_destino, 90);
                                break;
                            case 'png':
                                imagepng($imagen_redimensionada, $ruta_destino);
                                break;
                            case 'gif':
                                imagegif($imagen_redimensionada, $ruta_destino);
                                break;
                        }

                        imagedestroy($origen);
                        imagedestroy($imagen_redimensionada);

                        $tienda->Foto_Tienda = $nombre_archivo;
                    } else {
                        $alertas[] = "Formato de imagen no soportado para redimensionar.";
                    }
                } else {
                    $alertas[] = "Formato de archivo no permitido ($extension).";
                }
            }


            $alertas = array_merge($alertas, $tienda->validar());

            if (empty($alertas)) {
                if ($tienda->guardar()) {
                    header('Location: /admin/tienda/crearTienda?exito=1');
                    exit;
                }
                $alertas[] = "No se pudo guardar el registro.";
            }
        }

        $router->render('admin/tienda/crearTienda', [
            'titulo' => 'Crea una Tienda',
            'alertas' => $alertas,
            'nombre' => $nombre,
            'email' => $email,
            'bodega' => $bodega,
            'ciudad' => $ciudad,
            'tienda' => $tienda
        ]);
    }



// editar tienda
  

 public static function editarTienda(Router $router)
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
            header('Location: /admin/tienda/tablaTienda');
            exit;
        }

        $tienda =Tienda::find($id);
//  debuguear($tienda);

    



         if (!empty($_FILES['Foto_Tienda']['tmp_name'])) {
                $file = $_FILES['Foto_Tienda'];
                $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

                $carpeta_archivos = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/src/tiendas';
                if (!is_dir($carpeta_archivos)) {
                    mkdir($carpeta_archivos, 0755, true);
                }

                if (in_array($extension, $permitidos)) {
                    // Tamaño deseado
                    $ancho_final = 800;
                    $alto_final  = 600;

                    // Crear imagen desde el archivo original
                    switch ($extension) {
                        case 'jpg':
                        case 'jpeg':
                            $origen = imagecreatefromjpeg($file['tmp_name']);
                            break;
                        case 'png':
                            $origen = imagecreatefrompng($file['tmp_name']);
                            break;
                        case 'gif':
                            $origen = imagecreatefromgif($file['tmp_name']);
                            break;
                        default:
                            $origen = null;
                    }

                    if ($origen) {
                        $ancho_orig = imagesx($origen);
                        $alto_orig  = imagesy($origen);

                        // Crear lienzo con nuevas dimensiones
                        $imagen_redimensionada = imagecreatetruecolor($ancho_final, $alto_final);

                        // Mantener transparencia en PNG/GIF
                        if ($extension === 'png' || $extension === 'gif') {
                            imagecolortransparent(
                                $imagen_redimensionada,
                                imagecolorallocatealpha($imagen_redimensionada, 0, 0, 0, 127)
                            );
                            imagealphablending($imagen_redimensionada, false);
                            imagesavealpha($imagen_redimensionada, true);
                        }

                        // Redimensionar
                        imagecopyresampled(
                            $imagen_redimensionada,
                            $origen,
                            0,
                            0,
                            0,
                            0,
                            $ancho_final,
                            $alto_final,
                            $ancho_orig,
                            $alto_orig
                        );

                        // Nombre único (hash)
                        $nombre_archivo = bin2hex(random_bytes(16)) . '.' . $extension;
                        $ruta_destino   = $carpeta_archivos . '/' . $nombre_archivo;

                        // Guardar según tipo
                        switch ($extension) {
                            case 'jpg':
                            case 'jpeg':
                                imagejpeg($imagen_redimensionada, $ruta_destino, 90);
                                break;
                            case 'png':
                                imagepng($imagen_redimensionada, $ruta_destino);
                                break;
                            case 'gif':
                                imagegif($imagen_redimensionada, $ruta_destino);
                                break;
                        }

                        imagedestroy($origen);
                        imagedestroy($imagen_redimensionada);

                        $tienda->Foto_Tienda = $nombre_archivo;
                    } else {
                        $alertas[] = "Formato de imagen no soportado para redimensionar.";
                    }
                } else {
                    $alertas[] = "Formato de archivo no permitido ($extension).";
                }
            }
        $router->render('admin/tienda/editarTienda', [
            'titulo'  => 'EDITAR TIENDA',
            'nombre'  => $nombre,
            'email'   => $email,
            'tienda' => $tienda,
            'alertas' => $alertas,
            
        ]);
    }

















    // tabla de tienda
    public static function tablaTienda(Router $router): void
    {

        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $nombre = $_SESSION['nombre'];
        $email = $_SESSION['email'];

        $tienda =  Tienda::all();


        // debuguear($tienda);

        // Render a la vista
        $router->render('admin/tienda/tablaTienda', [
            'titulo' => 'Tabla de Tiendas',
            'tienda' => $tienda,
            'nombre' => $nombre,
            'email' => $email
        ]);
    }








}
