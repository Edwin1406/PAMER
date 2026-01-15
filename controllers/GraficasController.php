<?php

namespace Controllers;

use Model\Consumo_general;
use MVC\Router;

class GraficasController
{
 
    public static function graficasConsumoGeneral(Router $router)
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');
        }

        $email = $_SESSION['email'];
        $nombre = $_SESSION['nombre'];

        $router->render('admin/graficas/graficasConsumoGeneral', [
            'titulo' => 'Dashboard',
            'email' => $email,
            'nombre' => $nombre
        ]);
    }
    // api para las graficas consumo general
    public static function apiGraficasConsumoGeneral()
    {
        session_start();
        if (!isset($_SESSION['email'])) {
            header('Location: /');  
        }

        // Lógica para obtener los datos de la gráfica
        $datos = Consumo_general::all('ASC');

        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($datos);
        exit;
    }
    
    
    
    
    
}