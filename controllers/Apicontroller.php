<?php

namespace Controllers;

use Model\CambiosTurno;
use Model\Consumo_general;
use Model\DetalleEmpaque;
use Model\DetalleVenta;
use Model\Mantenimiento;
use Model\Prueba;
use Model\TurnoDiseno;
use Model\Ventas;

class Apicontroller
{

    // public static function apiConsumoGeneral():void {
    //     // CORS
    //     header('Access-Control-Allow-Origin: *');
    //     header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    //     header('Access-Control-Allow-Headers: Content-Type');

    //     $consmogeneral = Consumo_general::all('ASC');
    //     // Devolver los datos en formato JSON
    //     header('Content-Type: application/json');
    //     echo json_encode($consmogeneral);
    //     exit;
    // }
    public static function apiConsumoGeneral(): void
    {
        // CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        // Obtener los datos de la base de datos
        $consmogeneral = Consumo_general::all('ASC');

        // Convertir los valores de 'total_general' a números (decimales)
        foreach ($consmogeneral as &$registro) {
            $registro->total_general = (float) $registro->total_general;
        }

        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($consmogeneral);
        exit;
    }


    public static function apiMantenimiento(): void
    {
        $mantenimiento = Mantenimiento::all('ASC');
        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($mantenimiento);
        exit;
    }



    public static function apiDetalle(): void
    {
        // CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        $id = $_GET['id'] ?? '';
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            echo json_encode([]);
            return;
        }

        $turno = TurnoDiseno::where('id', $id);

        // $pedidos = Pedido::all();
        echo json_encode($turno);
    }




    public static function apiCambiosDiseno()
    {
        // CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        $codigo = $_GET['codigo'] ?? '';
        $codigo = strip_tags($codigo);
        if (!$codigo) {
            echo json_encode([]);
            return;
        }

        $cambios = CambiosTurno::whereCodigo('codigo', $codigo);
        echo json_encode($cambios);
    }




    // api apiEmpaque

    public static function apiEmpaque(): void
    {
        // CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        $empaque = Prueba::all('ASC');
        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($empaque);
        exit;
    }


    // api apiEmpaqueTiemposMuertos

    public static function apiEmpaqueTiemposMuertos(): void
    {
        // CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        $tiemposmuertos = DetalleEmpaque::all('ASC');
        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($tiemposmuertos);
        exit;
    }


    // api apiDesperdicioxSucesos

    public static function apiDesperdicioxSucesos(): void
    {
        // CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        $desperdicio = DetalleVenta::all('ASC');
        foreach ($desperdicio as &$item) {
            $item->cantidad = floatval($item->cantidad); // Convertir a número flotante
        }
        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($desperdicio);
        exit;
    }

    // api apiTotalDesperdicioIndividual
    public static function apiTotalDesperdicioIndividual(): void
    {
        // CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');

        $desperdicioindividual = Ventas::all('ASC');
        foreach ($desperdicioindividual as &$item) {
            $item->metros_lineales = floatval($item->metros_lineales); 
            $item->metros_lineales_C = floatval($item->metros_lineales_C);
            $item->consumo_almidon = floatval($item->consumo_almidon);
            $item->consumo_resina = floatval($item->consumo_resina);
            $item->consumo_recubrimiento = floatval($item->consumo_recubrimiento);
            $item->metros_lineales_B = floatval($item->metros_lineales_B);
            $item->metros_lineales_E = floatval($item->metros_lineales_E);
        }
        // Devolver los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($desperdicioindividual);
        exit;
    }
}
