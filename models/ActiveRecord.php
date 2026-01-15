<?php

namespace Model;

use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;




class ActiveRecord
{

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    // Setear un tipo de Alerta
    public static function setAlerta($tipo, $mensaje)
    {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Obtener las alertas
    public static function getAlertas()
    {
        return static::$alertas;
    }

    // Validación que se hereda en modelos
    public function validar()
    {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    // public function sanitizarAtributos() {
    //     $atributos = $this->atributos();
    //     $sanitizado = [];
    //     foreach($atributos as $key => $value ) {
    //         $sanitizado[$key] = self::$db->escape_string($value);
    //     }
    //     return $sanitizado;
    // }



    // public function sanitizarAtributos() {
    //     $atributos = $this->atributos();
    //     $sanitizado = [];
    //     foreach($atributos as $key => $value) {
    //         $sanitizado[$key] = self::$db->escape_string($value ?? '');
    //     }
    //     return $sanitizado;
    // }

    protected function sanitizarAtributos(): array
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;

            $valor = $this->$columna;

            // Si el valor es un array, convertirlo a string separado por comas
            if (is_array($valor)) {
                $valor = implode(',', $valor);
            }

            $atributos[$columna] = self::$db->escape_string($valor);
        }
        return $atributos;
    }



    // maximo valor de la ultima columna
  // Método para obtener el último código de nota pedido
public static function ultimoCodigo() {
    $query = "SELECT Codigo_Nota_Pedido FROM " . static::$tabla . " ORDER BY id DESC LIMIT 1";
    $resultado = self::$db->query($query);
    $registro = $resultado->fetch_assoc();
    // sumar 1 al codigo
    return $registro['Codigo_Nota_Pedido'] + 1;
}


    // protected function sanitizarAtributos(): array {
    //     $atributos = [];
    //     foreach (static::$columnasDB as $columna) {
    //         if ($columna === 'id') continue;

    //         $valor = $this->$columna;

    //         if (is_array($valor)) {
    //             $valor = implode(',', $valor);
    //         }

    //         $atributos[$columna] = self::$db->escape_string($valor ?? '');
    //     }
    //     return $atributos;
    // }





    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // public function sincronizar($args = []) {
    //     foreach($args as $key => $value) {
    //         if(property_exists($this, $key) && !is_null($value)) {
    //             $this->$key = is_string($value) ? trim($value) : $value;
    //         }
    //     }
    // }


    // Registros - CRUD

    public function guardar()
    {
        $resultado = '';
        if (!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }




    public function guardarCarrito()
    {
        $resultado = '';

        if (!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // crear
            $respuesta = $this->crear();

            // Si crear() devuelve el ID, asignarlo a la instancia
            if (is_array($respuesta) && isset($respuesta['id'])) {
                $this->id = $respuesta['id'];
                $resultado = $respuesta['resultado'];
            } else {
                $resultado = $respuesta;
            }
        }

        return $resultado;
    }





    // enviar on id para actualizar 
    public function guardarNuevo()
    {
        $resultado = '';
        if (!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crearNuevo();
        }
        return $resultado;
    }


    public function crearNuevo()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        // Resultado de la consulta
        $resultado = self::$db->query($query);

        // Asignar el ID generado al objeto
        if ($resultado) {
            $this->id = self::$db->insert_id;  // Asigna el ID generado
        }

        return [
            'resultado' =>  $resultado,
            'id' => $this->id // Retorna el ID asignado
        ];
    }







    // Obtener todos los Registros
    public static function all($orden = 'DESC')
    {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function clientesUnicos()
    {
        $query = "SELECT DISTINCT cliente FROM " . static::$tabla . " ORDER BY cliente ASC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }



    // devuelve array asociativo 
    public static function arrayasociativo($query)
    {
        $resultado = self::$db->query($query);
        $array = [];

        while ($fila = $resultado->fetch_assoc()) { // Devuelve un array asociativo en lugar de objetos
            $array[] = $fila;
        }

        return $array;
    }




    public static function datoscompletos($orden = 'DESC', $filtro = null)
    {
        $query = "SELECT * FROM " . static::$tabla;
        if ($filtro) {
            $query .= " WHERE linea LIKE '%{$filtro}%'";
        }
        $query .= " ORDER BY id {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    //-----------------------------------------------------------------------------

    public static function filtrarYPaginar($filtros, $limite, $offset)
    {
        $query = "SELECT * FROM pedidos WHERE 1";

        if (!empty($filtros['fecha_entrega'])) {
            $query .= " AND fecha_entrega = '" . self::$db->escape_string($filtros['fecha_entrega']) . "'";
        }

        if (!empty($filtros['test'])) {
            $query .= " AND test LIKE '%" . self::$db->escape_string($filtros['test']) . "%'";
        }

        $query .= " LIMIT {$limite} OFFSET {$offset}";

        return self::consultarSQL($query);
    }

    public static function total1($filtros = [])
    {
        $query = "SELECT COUNT(*) as total FROM pedidos WHERE 1";

        if (!empty($filtros['fecha_entrega'])) {
            $query .= " AND fecha_entrega = '" . self::$db->escape_string($filtros['fecha_entrega']) . "'";
        }

        if (!empty($filtros['test'])) {
            $query .= " AND test LIKE '%" . self::$db->escape_string($filtros['test']) . "%'";
        }

        $resultado = self::$db->query($query);
        $fila = $resultado->fetch_assoc();
        return $fila['total'] ?? 0;
    }








    //TRIMAR OBTENER SOLO CAJAS 

    public static function trimarcj($orden = 'DESC', $filtro = null)
    {
        $query = "SELECT * FROM " . static::$tabla;
        if ($filtro) {
            $query .= " WHERE nombre_pedido LIKE '%{$filtro}%'";
        }
        $query .= " ORDER BY id {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }






    // Obtener todos los registros con menos de 100 en existencia
    public static function menosDeCien($orden = 'DESC')
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE existencia <= 100 ORDER BY id {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }






    // public static function filtrarPorGramajeYAncho($gramaje = null, $ancho = null, $orden = 'DESC') {
    //     // Construir la base de la consulta
    //     $query = "SELECT * FROM " . static::$tabla;

    //     // Crear un array para las condiciones
    //     $condiciones = [];

    //     // Agregar condiciones según los parámetros recibidos
    //     if (!empty($gramaje)) {
    //         $condiciones[] = "gramaje = '" . self::escape($gramaje) . "'";
    //     }
    //     if (!empty($ancho)) {
    //         $condiciones[] = "ancho = '" . self::escape($ancho) . "'";
    //     }
    //     // Si hay condiciones, añadirlas a la consulta
    //     if (!empty($condiciones)) {
    //         $query .= " WHERE " . implode(' AND ', $condiciones);
    //     }

    //     // Agregar orden
    //     $query .= " ORDER BY id {$orden}";

    //     // Ejecutar la consulta y devolver los resultados
    //     $resultado = self::consultarSQL($query);
    //     return $resultado;
    // }


    protected static function escape($valor)
    {
        return mysqli_real_escape_string(self::$db, $valor);
    }


    public static function filtrarPorGramajeYAncho($gramajeRango = null, $ancho = null, $orden = 'DESC')
    {
        // Construir la base de la consulta
        $query = "SELECT * FROM " . static::$tabla;

        // Crear un array para las condiciones
        $condiciones = [];

        // Descomponer el rango de gramaje
        if (!empty($gramajeRango)) {
            [$gramajeMin, $gramajeMax] = explode('-', $gramajeRango);
            $condiciones[] = "gramaje BETWEEN '" . self::escape($gramajeMin) . "' AND '" . self::escape($gramajeMax) . "'";
        }

        // Agregar condiciones para el ancho
        if (!empty($ancho)) {
            $condiciones[] = "ancho = '" . self::escape($ancho) . "'";
        }

        // Si hay condiciones, añadirlas a la consulta
        if (!empty($condiciones)) {
            $query .= " WHERE " . implode(' AND ', $condiciones);
        }

        // Agregar orden
        $query .= " ORDER BY id {$orden}";

        // Ejecutar la consulta y devolver los resultados
        $resultado = self::consultarSQL($query);
        return $resultado;
    }



    // // Obtener todos los Registros con una condición caja
    // public static function allc($orden = 'DESC', $linea = null) {
    //     // Construye la consulta SQL base
    //     // $query = "SELECT * FROM " . static::$tabla;
    //     $query = "SELECT id,existencia,linea,gramaje,proveedor,sustrato,ancho FROM " . static::$tabla;


    //     // Agrega una cláusula WHERE si se proporciona un valor para $linea
    //     if ($linea !== null) {
    //         $query .= " WHERE linea LIKE '%" . addslashes($linea) . "%'";
    //     }

    //     // Agrega la cláusula ORDER BY
    //     $query .= " ORDER BY id {$orden}";

    //     // Ejecuta la consulta y devuelve el resultado
    //     $resultado = self::consultarSQL($query);
    //     return $resultado;
    // }


    // MATERIA PRIMA APIS

    public static function allc($orden = 'DESC', $lineas = null)
    {
        // Construye la consulta base
        $query = "SELECT id, existencia, linea, gramaje, proveedor, sustrato, ancho FROM " . static::$tabla;

        // Manejar múltiples líneas con coincidencias parciales
        if ($lineas !== null) {
            if (is_array($lineas)) {
                // Crear condiciones con LIKE para cada línea
                $condiciones = array_map(function ($linea) {
                    return "linea LIKE '%" . addslashes($linea) . "%'";
                }, $lineas);
                $query .= " WHERE " . implode(" OR ", $condiciones);
            } else {
                // Aplicar filtro normal si es solo un string
                $query .= " WHERE linea LIKE '%" . addslashes($lineas) . "%'";
            }
        }

        // Agrega la cláusula ORDER BY
        $query .= " ORDER BY id {$orden}";

        // Ejecuta la consulta y devuelve el resultado
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function allcIMPORT($orden = 'DESC', $lineas = null)
    {
        // Construye la consulta base con las columnas correctas
        $query = "SELECT id, import, proyecto, pedido_interno, fecha_solicitud, trader, marca, linea, producto, gramaje, ancho, 
              FORMAT(cantidad, 3) AS cantidad, precio, total_item, fecha_produccion, ets, eta, arribo_planta, transito, 
              fecha_en_planta, estado, fecha_corte 
              FROM " . static::$tabla;

        // Manejar múltiples líneas con coincidencias parciales
        if ($lineas !== null) {
            if (is_array($lineas)) {
                // Crear condiciones con LIKE para cada línea
                $condiciones = array_map(function ($linea) {
                    return "linea LIKE '%" . addslashes($linea) . "%'";
                }, $lineas);
                $query .= " WHERE " . implode(" OR ", $condiciones);
            } else {
                // Aplicar filtro normal si es solo un string
                $query .= " WHERE linea LIKE '%" . addslashes($lineas) . "%'";
            }
        }

        // Agrega la cláusula ORDER BY
        $query .= " ORDER BY id {$orden}";

        // Ejecuta la consulta y devuelve el resultado
        $resultado = self::consultarSQL($query);
        // debuguear($query);
        return $resultado;
    }
    // public static function allcIMPORT($orden = 'DESC', $lineas = null) {
    //     // Construye la consulta base sin el formato de cantidad
    //     $query = "SELECT id, import, proyecto, pedido_interno, fecha_solicitud, trader, marca, linea, producto, gramaje, ancho, cantidad, precio, total_item, fecha_produccion, ets, eta, arribo_planta, transito, 
    //        fecha_en_planta, estado, fecha_corte 
    //         FROM " . static::$tabla;
    //     // Manejar múltiples líneas con coincidencias parciales
    //     if ($lineas !== null) {
    //         if (is_array($lineas)) {
    //             // Crear condiciones con LIKE para cada línea
    //             $condiciones = array_map(function($linea) {
    //                 return "linea LIKE '%" . addslashes($linea) . "%'";
    //             }, $lineas);
    //             $query .= " WHERE " . implode(" OR ", $condiciones);
    //         } else {
    //             // Aplicar filtro normal si es solo un string
    //             $query .= " WHERE linea LIKE '%" . addslashes($lineas) . "%'";
    //         }
    //     }

    //     // Agrega la cláusula ORDER BY
    //     $query .= " ORDER BY id {$orden}";

    //     // Ejecuta la consulta y obtiene el resultado
    //     $resultado = self::consultarSQL($query);

    //     // Convierte la cantidad a float para cada resultado
    //     foreach ($resultado as $item) {
    //         // decimal_format($item->cantidad, 3);
    //         $item->cantidad = $item->cantidad; // Convierte la cantidad a float
    //     }

    //     return $resultado;
    // }







    public static function allcorrugador($orden = 'DESC', $lineas = null)
    {
        // Construye la consulta base
        $query = "SELECT id, existencia, linea, gramaje, proveedor, sustrato, ancho FROM " . static::$tabla;

        // Manejar múltiples líneas con coincidencias parciales
        $filtros = [];

        if ($lineas !== null) {
            if (is_array($lineas)) {
                // Crear condiciones con LIKE para cada línea
                $condiciones = array_map(function ($linea) {
                    return "linea LIKE '%" . addslashes($linea) . "%'";
                }, $lineas);
                $filtros[] = "(" . implode(" OR ", $condiciones) . ")";
            } else {
                $filtros[] = "linea LIKE '%" . addslashes($lineas) . "%'";
            }
        }

        // Filtro adicional para los anchos específicos
        $filtros[] = "(ancho = 1880 OR ancho = 1100)";

        // Si hay filtros, agrégalos a la consulta
        if (!empty($filtros)) {
            $query .= " WHERE " . implode(" AND ", $filtros);
        }

        // Agrega la cláusula ORDER BY
        $query .= " ORDER BY id {$orden}";

        // Ejecuta la consulta y devuelve el resultado
        $resultado = self::consultarSQL($query);
        return $resultado;
    }


    public static function allcorrugadorsobrante($orden = 'DESC', $lineas = null)
    {
        // Construye la consulta base
        $query = "SELECT id, existencia, linea, gramaje, proveedor, sustrato, ancho FROM " . static::$tabla;

        // Manejar múltiples líneas con coincidencias parciales
        $filtros = [];

        if ($lineas !== null) {
            if (is_array($lineas)) {
                // Crear condiciones con LIKE para cada línea
                $condiciones = array_map(function ($linea) {
                    return "linea LIKE '%" . addslashes($linea) . "%'";
                }, $lineas);
                $filtros[] = "(" . implode(" OR ", $condiciones) . ")";
            } else {
                $filtros[] = "linea LIKE '%" . addslashes($lineas) . "%'";
            }
        }

        // Filtro adicional para excluir anchos específicos
        $filtros[] = "(ancho <> 1880 AND ancho <> 1100)";

        // Si hay filtros, agrégalos a la consulta
        if (!empty($filtros)) {
            $query .= " WHERE " . implode(" AND ", $filtros);
        }

        // Agrega la cláusula ORDER BY
        $query .= " ORDER BY id {$orden}";

        // Ejecuta la consulta y devuelve el resultado
        $resultado = self::consultarSQL($query);
        return $resultado;
    }






    // Obtener todos los Registros con una condición caja
    public static function allcc($orden = 'DESC', $linea = null)
    {
        // Construye la consulta SQL base
        // $query = "SELECT * FROM " . static::$tabla;
        $query = "SELECT * FROM " . static::$tabla;


        // Agrega una cláusula WHERE si se proporciona un valor para $linea
        if ($linea !== null) {
            $query .= " WHERE linea LIKE '%" . addslashes($linea) . "%'";
        }

        // Agrega la cláusula ORDER BY
        $query .= " ORDER BY id {$orden}";

        // Ejecuta la consulta y devuelve el resultado
        $resultado = self::consultarSQL($query);
        return $resultado;
    }









    // contador de registro por linea
    public static function countByLinea($linea = null)
    {
        // Construye la consulta base
        $query = "SELECT COUNT(*) as total FROM " . static::$tabla;
        // Agrega una cláusula WHERE si se proporciona un valor para $linea
        if ($linea !== null) {
            $query .= " WHERE linea LIKE '%" . addslashes($linea) . "%'";
        }
        // Ejecuta la consulta y obtiene el resultado
        $resultado = self::consultarSQL1($query);
        // Devuelve el total si existe en el resultado
        if (is_array($resultado) && isset($resultado[0]['total'])) {
            return (int) $resultado[0]['total'];
        }
        return 0;
    }

    public static function consultarSQL1($query)
    {
        $resultado = self::$db->query($query);
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = $registro;
        }
        return $array;
    }

    // sumar existencia 

    public static function sumarExistencia($linea = null)
    {
        // Construye la consulta SQL base
        $query = "SELECT  SUM(existencia) as total FROM " . static::$tabla;

        // Agrega una cláusula WHERE si se proporciona un valor para $linea
        if ($linea !== null) {
            $query .= " WHERE linea LIKE '%" . addslashes($linea) . "%'";
        }
        // Ejecutar la consulta usando `consultarValor`
        return (float) self::consultarValor($query);
    }




    // sumar costo
    public static function sumarCosto($linea = null)
    {
        // Construye la consulta SQL base
        $query = "SELECT SUM(costo) as total FROM " . static::$tabla;

        // Agrega una cláusula WHERE si se proporciona un valor para $linea
        if ($linea !== null) {
            $query .= " WHERE linea LIKE '%" . addslashes($linea) . "%'";
        }
        // Ejecutar la consulta usando `consultarValor`
        return (float) self::consultarValor($query);
    }



    public static function allKilogramos()
    {
        // Construye la consulta SQL base
        $query = "SELECT SUM(existencia) as total FROM " . static::$tabla;
        // Ejecutar la consulta usando `consultarValor`
        return (float) self::consultarValor($query);
    }



    public static function consultarValor($query)
    {
        // Ejecutar la consulta
        $resultado = self::$db->query($query);
        // Obtener la primera fila del resultado
        $fila = $resultado->fetch_assoc();
        // Liberar la memoria
        $resultado->free();

        // Retornar el primer valor (primer columna de la fila)
        return $fila ? array_values($fila)[0] : 0;
    }






    // Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }


    // Busca un registro por su id_orden
    public static function find_orden($id_orden)
    {
        // Suponiendo que $db es el objeto mysqli conectado
        $stmt = self::$db->prepare("SELECT * FROM " . static::$tabla . " WHERE id_orden = ?");
        $stmt->bind_param('s', $id_orden);  // 's' para string, cambia si es otro tipo
        $stmt->execute();
        $result = $stmt->get_result();
        $registro = $result->fetch_assoc();
        $stmt->close();
        return $registro;
    }




    // Obtener Registros con cierta cantidad
    public static function get($limite)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT {$limite} ORDER BY id DESC";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // del paginador 
    public static function paginar($por_pagina, $offset)
    {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT {$por_pagina}  OFFSET {$offset} ";
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }



    // Busqueda Where con Columna 
    public static function where($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }


    public static function whereDosCondiciones($columna1, $valor1, $columna2, $valor2)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna1} = '{$valor1}' AND {$columna2} = '{$valor2}'";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado); // Devuelve el primer resultado si existe
    }



    public static function wherenuevo($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado; // Ahora devuelve todos los resultados
    }


    // ELIMINAR UN REGISTRO POR SU ID
    public static function eliminarPorColumna($columna, $valor)
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'";
        return self::$db->query($query);
    }






    // Retornar los registros por un orden 

    public static function ordenar($columna, $orden)
    {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY {$columna} {$orden}";
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }





    // Busqueda Where con multiples columnas
    public static function whereArray($array = [])
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ";
        foreach ($array as $key => $value) {
            if ($key === array_key_last($array)) {

                $query .= "{$key} = '{$value}'";
            } else {

                $query .= "{$key} = '{$value}' AND ";
            }
        }
        // echo $query;

        $resultado = self::consultarSQL($query);
        return  $resultado;
    }


    // traer un total de registros count
    public static function total($columna = '', $valor = ''): string
    {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        if ($columna) {
            $query .= " WHERE {$columna} = '{$valor}'";
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();
        return array_shift($total);
    }



    //  Total con un array where
    public static function totalArray($array = [])
    {
        $query = "SELECT COUNT(*) FROM " . static::$tabla . "WHERE ";
        foreach ($array as $key => $value) {
            if ($key == array_key_last($array)) {
                $query .= "{$key} = '{$value}'";
            } else {

                $query .= "  {$key} = '{$value}' AND ";
            }
        }
        $resultado = self::$db->query($query);
        $total = $resultado->fetch_array();
        return array_shift($total);
    }


    public static function topProductos($columna)
    {
        // Cambiar la agrupación por 'nombre' en lugar de 'cantidad'
        $query = "SELECT nombre, SUM(cantidad) AS total FROM " . static::$tabla . " GROUP BY nombre ORDER BY total DESC LIMIT 10";
        $resultado = self::consultarSQL($query);
        return  $resultado;
    }





    // crea un nuevo registro
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        // debuguear($query); // Descomentar si no te funciona algo

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
            'resultado' =>  $resultado,
            'id' => self::$db->insert_id
        ];
    }

    //    // Procesar un archivo Excel-----------------------------------------------------------------------------------------------------------------------------------



    // public static function procesarArchivoExcel($filePath)
    // {
    //     $spreadsheet = IOFactory::load($filePath);
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Crear la tabla si no existe
    //     $queryCrearTabla = "
    //         CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
    //             almacen VARCHAR(255),
    //             nombre_cliente VARCHAR(255),
    //             ruc_cliente VARCHAR(255),
    //             numero_pedido VARCHAR(255),
    //             fecha_pedido DATE,
    //             vendedor VARCHAR(255),
    //             plazo_entrega DATE,
    //             estado_pedido VARCHAR(255),
    //             codigo_producto VARCHAR(255),
    //             nombre_producto VARCHAR(255),
    //             cantidad INT,
    //             pvp DECIMAL(10, 2),
    //             subtotal DECIMAL(10, 2),
    //             total DECIMAL(10, 2),
    //             PRIMARY KEY (numero_pedido, codigo_producto)  -- Asegúrate de tener una clave primaria
    //         )
    //     ";

    //     // Ejecutar la creación de la tabla
    //     self::$db->query($queryCrearTabla);

    //     // Insertar los datos de cada fila
    //     foreach ($sheet->getRowIterator(2) as $row) {
    //         $data = [];
    //         $cellIterator = $row->getCellIterator();
    //         $cellIterator->setIterateOnlyExistingCells(false);

    //         foreach ($cellIterator as $cell) {
    //             $data[] = $cell->getValue(); // No usamos trim aquí, lo haremos más abajo
    //         }

    //         // Mapear los datos a las columnas con verificación para null
    //         list(
    //             $almacen, $nombre_cliente, $ruc_cliente, $numero_pedido, $fecha_pedido,
    //             $vendedor, $plazo_entrega, $estado_pedido, $codigo_producto, $nombre_producto,
    //             $cantidad, $pvp, $subtotal, $total
    //         ) = array_map(function ($value) {
    //             return trim($value ?? '');  // Verifica si el valor es null y aplica trim
    //         }, $data);

    //         // Verificar si el registro ya existe
    //         $queryVerificar = "
    //             SELECT COUNT(*) as total 
    //             FROM " . static::$tabla . " 
    //             WHERE numero_pedido = '$numero_pedido' AND codigo_producto = '$codigo_producto'
    //         ";
    //         $resultado = self::$db->query($queryVerificar)->fetch_assoc();

    //         if ($resultado['total'] > 0) {
    //             // Actualizar el registro existente
    //             $queryActualizar = "
    //                 UPDATE " . static::$tabla . "
    //                 SET 
    //                     almacen = '$almacen',
    //                     nombre_cliente = '$nombre_cliente',
    //                     ruc_cliente = '$ruc_cliente',
    //                     fecha_pedido = '$fecha_pedido',
    //                     vendedor = '$vendedor',
    //                     plazo_entrega = '$plazo_entrega',

    //                     nombre_producto = '$nombre_producto',
    //                     cantidad = '$cantidad',
    //                     pvp = '$pvp',
    //                     subtotal = '$subtotal',
    //                     total = '$total'
    //                 WHERE numero_pedido = '$numero_pedido' AND codigo_producto = '$codigo_producto'
    //             ";
    //             self::$db->query($queryActualizar);
    //         } else {
    //             // Insertar un nuevo registro
    //             $queryInsertar = "
    //                 INSERT INTO " . static::$tabla . " (
    //                     almacen, nombre_cliente, ruc_cliente, numero_pedido, fecha_pedido,
    //                     vendedor, plazo_entrega, estado_pedido, codigo_producto, nombre_producto,
    //                     cantidad, pvp, subtotal, total
    //                 ) VALUES (
    //                     '$almacen', '$nombre_cliente', '$ruc_cliente', '$numero_pedido', '$fecha_pedido',
    //                     '$vendedor', '$plazo_entrega', '$estado_pedido', '$codigo_producto', '$nombre_producto',
    //                     '$cantidad', '$pvp', '$subtotal', '$total'
    //                 )
    //             ";
    //             self::$db->query($queryInsertar);
    //         }
    //     }

    //     return true;
    // }
    public static function procesarArchivoExcel($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Crear la tabla si no existe
        $queryCrearTabla = "
        CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
            almacen VARCHAR(255),
            nombre_cliente VARCHAR(255),
            ruc_cliente VARCHAR(255),
            numero_pedido VARCHAR(255),
            fecha_pedido DATE,
            vendedor VARCHAR(255),
            plazo_entrega DATE,
            estado_pedido VARCHAR(255),
            codigo_producto VARCHAR(255),
            nombre_producto VARCHAR(255),
            cantidad INT,
            pvp DECIMAL(10, 2),
            subtotal DECIMAL(10, 2),
            total DECIMAL(10, 2),
            PRIMARY KEY (numero_pedido, codigo_producto)  -- Asegúrate de tener una clave primaria
        )
    ";

        // Ejecutar la creación de la tabla
        self::$db->query($queryCrearTabla);

        // Insertar los datos de cada fila
        foreach ($sheet->getRowIterator(2) as $row) {
            $data = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue(); // No usamos trim aquí, lo haremos más abajo
            }

            // Mapear los datos a las columnas con verificación para null
            list(
                $almacen,
                $nombre_cliente,
                $ruc_cliente,
                $numero_pedido,
                $fecha_pedido,
                $vendedor,
                $plazo_entrega,
                $estado_pedido,
                $codigo_producto,
                $nombre_producto,
                $cantidad,
                $pvp,
                $subtotal,
                $total
            ) = array_map(function ($value) {
                return trim($value ?? '');  // Verifica si el valor es null y aplica trim
            }, $data);

            // Comprobar si el nombre_producto comienza con alguno de los valores no deseados
            if (preg_match('/^(LM|CIRELES|CHRYSAL|Z|GUANTE)/', $nombre_producto)) {
                // Si coincide, se omite el registro
                continue;
            }

            // Verificar si el registro ya existe
            $queryVerificar = "
            SELECT COUNT(*) as total 
            FROM " . static::$tabla . " 
            WHERE numero_pedido = '$numero_pedido' AND codigo_producto = '$codigo_producto'
        ";
            $resultado = self::$db->query($queryVerificar)->fetch_assoc();

            if ($resultado['total'] > 0) {
                // Actualizar el registro existente
                $queryActualizar = "
                UPDATE " . static::$tabla . "
                SET 
                    almacen = '$almacen',
                    nombre_cliente = '$nombre_cliente',
                    ruc_cliente = '$ruc_cliente',
                    fecha_pedido = '$fecha_pedido',
                    vendedor = '$vendedor',
                    plazo_entrega = '$plazo_entrega',
                    nombre_producto = '$nombre_producto',
                    cantidad = '$cantidad',
                    pvp = '$pvp',
                    subtotal = '$subtotal',
                    total = '$total'
                WHERE numero_pedido = '$numero_pedido' AND codigo_producto = '$codigo_producto'
            ";
                self::$db->query($queryActualizar);
            } else {
                // Insertar un nuevo registro
                $queryInsertar = "
                INSERT INTO " . static::$tabla . " (
                    almacen, nombre_cliente, ruc_cliente, numero_pedido, fecha_pedido,
                    vendedor, plazo_entrega, estado_pedido, codigo_producto, nombre_producto,
                    cantidad, pvp, subtotal, total
                ) VALUES (
                    '$almacen', '$nombre_cliente', '$ruc_cliente', '$numero_pedido', '$fecha_pedido',
                    '$vendedor', '$plazo_entrega', '$estado_pedido', '$codigo_producto', '$nombre_producto',
                    '$cantidad', '$pvp', '$subtotal', '$total'
                )
            ";
                self::$db->query($queryInsertar);
            }
        }

        return true;
    }


    // ---------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // Procesar un archivo Excel para Materia Prima


    // public static function procesarArchivoExcelMateria($filePath)
    // {
    //     $spreadsheet = IOFactory::load($filePath);
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Crear la tabla SIN restricciones de UNIQUE en 'codigo'
    //     $queryCrearTabla = "
    //         CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
    //             id INT AUTO_INCREMENT PRIMARY KEY,
    //             almacen VARCHAR(255),
    //             codigo VARCHAR(255),
    //             descripcion VARCHAR(500),
    //             existencia INT,
    //             costo DECIMAL(10, 2),
    //             promedio DECIMAL(10, 2),
    //             talla VARCHAR(255),
    //             linea VARCHAR(255),
    //             gramaje VARCHAR(255),
    //             proveedor VARCHAR(255),
    //             sustrato VARCHAR(255),
    //             ancho VARCHAR(255),
    //             fecha_corte DATE DEFAULT CURRENT_DATE
    //         )
    //     ";
    //     self::$db->query($queryCrearTabla);

    //     // Procesar cada fila del Excel (desde la fila 2)
    //     foreach ($sheet->getRowIterator(2) as $row) {
    //         $data = [];
    //         $cellIterator = $row->getCellIterator();
    //         $cellIterator->setIterateOnlyExistingCells(false);

    //         foreach ($cellIterator as $cell) {
    //             $data[] = trim((string)$cell->getFormattedValue());
    //         }

    //         // Validar al menos 12 columnas (sin fecha_corte)
    //         if (count($data) < 12) {
    //             continue;
    //         }

    //         // Mapear los datos (sin fecha_corte)
    //         list(
    //             $almacen, $codigo, $descripcion, $existencia, $costo,
    //             $promedio, $talla, $linea, $gramaje, $proveedor,
    //             $sustrato, $ancho
    //         ) = array_map(function ($value) {
    //             return trim($value ?? '');
    //         }, $data);

    //         // Convertir tipos
    //         $costo = floatval(str_replace(',', '.', $costo));
    //         $promedio = floatval(str_replace(',', '.', $promedio));
    //         $existencia = intval($existencia);

    //         // Insertar SIN fecha_corte (MySQL la pone automáticamente)
    //         $queryInsertar = "
    //             INSERT INTO " . static::$tabla . " (
    //                 almacen, codigo, descripcion, existencia, costo,
    //                 promedio, talla, linea, gramaje, proveedor,
    //                 sustrato, ancho
    //             ) VALUES (
    //                 '" . self::$db->real_escape_string($almacen) . "',
    //                 '" . self::$db->real_escape_string($codigo) . "',
    //                 '" . self::$db->real_escape_string($descripcion) . "',
    //                 $existencia,
    //                 $costo,
    //                 $promedio,
    //                 '" . self::$db->real_escape_string($talla) . "',
    //                 '" . self::$db->real_escape_string($linea) . "',
    //                 '" . self::$db->real_escape_string($gramaje) . "',
    //                 '" . self::$db->real_escape_string($proveedor) . "',
    //                 '" . self::$db->real_escape_string($sustrato) . "',
    //                 '" . self::$db->real_escape_string($ancho) . "'
    //             )
    //         ";
    //         self::$db->query($queryInsertar);
    //     }

    //     return true;
    // }


    public static function procesarArchivoExcelMateria($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Crear la tabla si no existe (sin restricción UNIQUE)
        $queryCrearTabla = "
        CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
            id INT AUTO_INCREMENT PRIMARY KEY,
            almacen VARCHAR(255),
            codigo VARCHAR(255),
            descripcion VARCHAR(500),
            existencia INT,
            costo DECIMAL(10, 2),
            promedio DECIMAL(10, 2),
            talla VARCHAR(255),
            linea VARCHAR(255),
            gramaje VARCHAR(255),
            proveedor VARCHAR(255),
            sustrato VARCHAR(255),
            ancho VARCHAR(255),
            fecha_corte DATE DEFAULT CURRENT_DATE
        )
    ";
        self::$db->query($queryCrearTabla);

        // Verificar si ya existen registros con la fecha actual
        $queryFechaActual = "
        SELECT COUNT(*) AS cantidad 
        FROM " . static::$tabla . " 
        WHERE fecha_corte = CURRENT_DATE
    ";
        $resultado = self::$db->query($queryFechaActual);
        $fila = $resultado->fetch_assoc();

        if ($fila['cantidad'] > 0) {
            // Ya hay registros con la fecha de hoy: evitar duplicar
            return false;
        }

        // Procesar cada fila desde la fila 2
        foreach ($sheet->getRowIterator(2) as $row) {
            $data = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            foreach ($cellIterator as $cell) {
                $data[] = trim((string)$cell->getFormattedValue());
            }

            if (count($data) < 12) {
                continue; // Ignorar filas incompletas
            }

            list(
                $almacen,
                $codigo,
                $descripcion,
                $existencia,
                $costo,
                $promedio,
                $talla,
                $linea,
                $gramaje,
                $proveedor,
                $sustrato,
                $ancho
            ) = array_map(function ($value) {
                return trim($value ?? '');
            }, $data);

            $costo = floatval(str_replace(',', '.', $costo));
            $promedio = floatval(str_replace(',', '.', $promedio));
            $existencia = intval($existencia);

            $queryInsertar = "
            INSERT INTO " . static::$tabla . " (
                almacen, codigo, descripcion, existencia, costo,
                promedio, talla, linea, gramaje, proveedor,
                sustrato, ancho
            ) VALUES (
                '" . self::$db->real_escape_string($almacen) . "',
                '" . self::$db->real_escape_string($codigo) . "',
                '" . self::$db->real_escape_string($descripcion) . "',
                $existencia,
                $costo,
                $promedio,
                '" . self::$db->real_escape_string($talla) . "',
                '" . self::$db->real_escape_string($linea) . "',
                '" . self::$db->real_escape_string($gramaje) . "',
                '" . self::$db->real_escape_string($proveedor) . "',
                '" . self::$db->real_escape_string($sustrato) . "',
                '" . self::$db->real_escape_string($ancho) . "'
            )
        ";
            self::$db->query($queryInsertar);
        }

        return true;
    }




    // ----------------------------------------------------------------------------EXCEL COMERCIAL---------------------------------------------------------------------------
    // public static function procesarArchivoExcelComercial($filePath)
    // {
    //     $spreadsheet = IOFactory::load($filePath);
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Crear la tabla si no existe
    //     $queryCrearTabla = "
    //         CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
    //             id INT AUTO_INCREMENT PRIMARY KEY,
    //             import VARCHAR(255),
    //             proyecto VARCHAR(255),
    //             pedido_interno VARCHAR(255),
    //             fecha_solicitud DATE,
    //             trader VARCHAR(255),
    //             marca VARCHAR(255),
    //             linea VARCHAR(255),
    //             producto VARCHAR(500),
    //             gramaje VARCHAR(255),
    //             ancho VARCHAR(255),
    //             cantidad VARCHAR(255),
    //             precio VARCHAR(255),
    //             total_item VARCHAR(255),
    //             fecha_produccion DATE,
    //             ets DATE,
    //             eta DATE,
    //             arribo_planta DATE,
    //             transito INT,
    //             fecha_en_planta DATE,
    //             estado VARCHAR(255),
    //             fecha_corte DATE DEFAULT CURRENT_DATE,

    //             UNIQUE KEY (import, proyecto, pedido_interno, fecha_solicitud, trader, marca, linea, producto, gramaje, ancho, cantidad, precio, total_item, fecha_produccion, ets, eta, arribo_planta, transito, fecha_en_planta, estado)
    //         )
    //     ";

    //     self::$db->query($queryCrearTabla);

    //     $highestRow = $sheet->getHighestRow();
    //     for ($row = 2; $row <= $highestRow; $row++) {
    //         $data = [];
    //         for ($col = 'A'; $col <= 'U'; $col++) {
    //             $data[] = trim($sheet->getCell($col . $row)->getFormattedValue() ?? '');
    //         }

    //         list(
    //             $import, $proyecto, $pedido_interno, $fecha_solicitud,
    //             $trader, $marca, $linea, $producto, $gramaje, $ancho, $cantidad,
    //             $precio, $total_item, $fecha_produccion, $ets, $eta,
    //             $arribo_planta, $transito, $fecha_en_planta, $estado
    //         ) = array_map(fn($value) => is_numeric(str_replace(',', '.', $value)) ? str_replace(',', '.', $value) : trim($value), $data);

    //         // Validación de fechas
    //         $fechas = ['fecha_solicitud', 'fecha_produccion', 'ets', 'eta', 'arribo_planta', 'fecha_en_planta'];
    //         foreach ($fechas as $fecha) {
    //             if (!empty($$fecha) && strtotime($$fecha) !== false) {
    //                 $$fecha = date('Y-m-d', strtotime($$fecha));
    //             } else {
    //                 $$fecha = null; // Evita insertar valores inválidos
    //             }
    //         }

    //         // Asegurar que `gms` y `ancho` sean numéricos
    //         $gramaje = is_numeric($gramaje) ? floatval($gramaje) : null;
    //         $ancho = is_numeric($ancho) ? floatval($ancho) : null;

    //         // **Verificar si el registro ya existe antes de insertarlo**
    //         $queryExistente = "
    //             SELECT id FROM " . static::$tabla . "
    //             WHERE import = '$import' 
    //             AND proyecto = '$proyecto'
    //             AND pedido_interno = '$pedido_interno'
    //             AND fecha_solicitud = '$fecha_solicitud'
    //             AND trader = '$trader'
    //             AND marca = '$marca'
    //             AND linea = '$linea'
    //             AND producto = '$producto'
    //             AND gramaje = '$gramaje'
    //             AND ancho = '$ancho'
    //             AND cantidad = '$cantidad'
    //             AND precio = '$precio'
    //             AND total_item = '$total_item'
    //             AND fecha_produccion = '$fecha_produccion'
    //             AND ets = '$ets'
    //             AND eta = '$eta'
    //             AND arribo_planta = '$arribo_planta'
    //             AND transito = '$transito'
    //             AND fecha_en_planta = '$fecha_en_planta'
    //             AND estado = '$estado'
    //         ";

    //         $resultado = self::$db->query($queryExistente);
    //         if ($resultado->num_rows == 0) {
    //             // Solo insertar si NO existe
    //             $queryInsertar = "
    //                 INSERT INTO " . static::$tabla . " (
    //                     import, proyecto, pedido_interno, fecha_solicitud, trader, marca, linea, producto,
    //                     gramaje, ancho, cantidad, precio, total_item, fecha_produccion, ets, eta,
    //                     arribo_planta, transito, fecha_en_planta, estado
    //                 ) VALUES (
    //                     '$import', '$proyecto', '$pedido_interno', '$fecha_solicitud', '$trader',
    //                     '$marca', '$linea', '$producto', '$gramaje', '$ancho', '$cantidad',
    //                     '$precio', '$total_item', '$fecha_produccion', '$ets', '$eta',
    //                     '$arribo_planta', '$transito', '$fecha_en_planta', '$estado'
    //                 )
    //             ";
    //             self::$db->query($queryInsertar);
    //         }
    //     }

    //     return true;
    // }

    // public static function procesarArchivoExcelComercial($filePath)
    // {
    //     $spreadsheet = IOFactory::load($filePath);
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Crear la tabla si no existe
    //     $queryCrearTabla = "
    //         CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
    //             id INT AUTO_INCREMENT PRIMARY KEY,
    //             import VARCHAR(255),
    //             proyecto VARCHAR(255),
    //             pedido_interno VARCHAR(255),
    //             fecha_solicitud DATE,
    //             trader VARCHAR(255),
    //             marca VARCHAR(255),
    //             linea VARCHAR(255),
    //             producto VARCHAR(500),
    //             gramaje VARCHAR(255),
    //             ancho VARCHAR(255),
    //             cantidad VARCHAR(255),
    //             precio VARCHAR(255),
    //             total_item VARCHAR(255),
    //             fecha_produccion DATE,
    //             ets DATE,
    //             eta DATE,
    //             arribo_planta DATE,
    //             transito INT,
    //             fecha_en_planta DATE,
    //             estado VARCHAR(255),
    //             fecha_corte DATE DEFAULT CURRENT_DATE,

    //             UNIQUE KEY (import, proyecto, pedido_interno, fecha_solicitud, trader, marca, linea, producto, gramaje, ancho, cantidad, precio, total_item, fecha_produccion, ets, eta, arribo_planta, transito, fecha_en_planta, estado)
    //         )
    //     ";

    //     self::$db->query($queryCrearTabla);

    //     $highestRow = $sheet->getHighestRow();
    //     for ($row = 2; $row <= $highestRow; $row++) {
    //         $data = [];
    //         for ($col = 'A'; $col <= 'U'; $col++) {
    //             $data[] = trim($sheet->getCell($col . $row)->getFormattedValue() ?? '');
    //         }

    //         list(
    //             $import, $proyecto, $pedido_interno, $fecha_solicitud,
    //             $trader, $marca, $linea, $producto, $gramaje, $ancho, $cantidad,
    //             $precio, $total_item, $fecha_produccion, $ets, $eta,
    //             $arribo_planta, $transito, $fecha_en_planta, $estado
    //         ) = array_map(fn($value) => is_numeric(str_replace(',', '.', $value)) ? str_replace(',', '.', $value) : trim($value), $data);

    //         // Validación de fechas
    //         $fechas = ['fecha_solicitud', 'fecha_produccion', 'ets', 'eta', 'arribo_planta', 'fecha_en_planta'];
    //         foreach ($fechas as $fecha) {
    //             if (!empty($$fecha) && strtotime($$fecha) !== false) {
    //                 $$fecha = date('Y-m-d', strtotime($$fecha));
    //             } else {
    //                 $$fecha = null; // Evita insertar valores inválidos
    //             }
    //         }

    //         // Asegurar que `gramaje` y `ancho` sean numéricos
    //         $gramaje = is_numeric($gramaje) ? floatval($gramaje) : null;
    //         $ancho = is_numeric($ancho) ? floatval($ancho) : null;

    //         // Verificar si el registro ya existe
    //         $queryExistente = "
    //             SELECT id FROM " . static::$tabla . "
    //             WHERE import = '$import' 
    //             AND proyecto = '$proyecto'
    //             AND pedido_interno = '$pedido_interno'
    //             AND fecha_solicitud = '$fecha_solicitud'
    //             AND trader = '$trader'
    //             AND marca = '$marca'
    //             AND linea = '$linea'
    //             AND producto = '$producto'
    //             AND gramaje = '$gramaje'
    //             AND ancho = '$ancho'
    //             AND cantidad = '$cantidad'
    //             AND precio = '$precio'
    //             AND total_item = '$total_item'
    //             AND fecha_produccion = '$fecha_produccion'
    //             AND ets = '$ets'
    //             AND eta = '$eta'
    //             AND arribo_planta = '$arribo_planta'
    //             AND transito = '$transito'
    //             AND fecha_en_planta = '$fecha_en_planta'
    //             AND estado = '$estado'

    //         ";

    //         $resultado = self::$db->query($queryExistente);
    //         if ($resultado->num_rows == 0) {
    //             // Insertar si no existe
    //             $fecha_corte = date('Y-m-d');
    //             $queryInsertar = "
    //                 INSERT INTO " . static::$tabla . " (
    //                     import, proyecto, pedido_interno, fecha_solicitud, trader, marca, linea, producto,
    //                     gramaje, ancho, cantidad, precio, total_item, fecha_produccion, ets, eta,
    //                     arribo_planta, transito, fecha_en_planta, estado, fecha_corte
    //                 ) VALUES (
    //                     '$import', '$proyecto', '$pedido_interno', '$fecha_solicitud', '$trader',
    //                     '$marca', '$linea', '$producto', '$gramaje', '$ancho', '$cantidad',
    //                     '$precio', '$total_item', '$fecha_produccion', '$ets', '$eta',
    //                     '$arribo_planta', '$transito', '$fecha_en_planta', '$estado', '$fecha_corte'
    //                 )
    //             ";
    //             self::$db->query($queryInsertar);
    //         }
    //     }

    //     return true;
    // }


    public static function procesarArchivoExcelComercial($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Crear la tabla si no existe (sin restricción UNIQUE)
        $queryCrearTabla = "
        CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
            id INT AUTO_INCREMENT PRIMARY KEY,
            import VARCHAR(255),
            proyecto VARCHAR(255),
            pedido_interno VARCHAR(255),
            fecha_solicitud DATE,
            trader VARCHAR(255),
            marca VARCHAR(255),
            linea VARCHAR(255),
            producto VARCHAR(500),
            gramaje VARCHAR(255),
            ancho VARCHAR(255),
            cantidad DECIMAL(10, 3),
            precio VARCHAR(255),
            total_item VARCHAR(255),
            fecha_produccion DATE,
            ets DATE,
            eta DATE,
            arribo_planta DATE,
            transito INT,
            fecha_en_planta DATE,
            estado VARCHAR(255),
            fecha_corte DATE DEFAULT CURRENT_DATE
        )
    ";
        self::$db->query($queryCrearTabla);

        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $data = [];
            for ($col = 'A'; $col <= 'U'; $col++) {
                $data[] = trim($sheet->getCell($col . $row)->getFormattedValue() ?? '');
            }

            list(
                $import,
                $proyecto,
                $pedido_interno,
                $fecha_solicitud,
                $trader,
                $marca,
                $linea,
                $producto,
                $gramaje,
                $ancho,
                $cantidad,
                $precio,
                $total_item,
                $fecha_produccion,
                $ets,
                $eta,
                $arribo_planta,
                $transito,
                $fecha_en_planta,
                $estado
            ) = array_map(fn($value) => is_numeric(str_replace(',', '.', $value)) ? str_replace(',', '.', $value) : trim($value), $data);

            // Validación de fechas
            $fechas = ['fecha_solicitud', 'fecha_produccion', 'ets', 'eta', 'arribo_planta', 'fecha_en_planta'];
            foreach ($fechas as $fecha) {
                if (!empty($$fecha) && strtotime($$fecha) !== false) {
                    $$fecha = date('Y-m-d', strtotime($$fecha));
                } else {
                    $$fecha = null;
                }
            }

            $gramaje = is_numeric($gramaje) ? floatval($gramaje) : null;
            $ancho = is_numeric($ancho) ? floatval($ancho) : null;

            // Fecha de corte actual
            $fecha_corte = date('Y-m-d');

            // Verificar si ya existe con la misma fecha_corte
            $queryExistente = "
            SELECT id FROM " . static::$tabla . "
            WHERE import = '$import' 
            AND proyecto = '$proyecto'
            AND pedido_interno = '$pedido_interno'
            AND fecha_solicitud = '$fecha_solicitud'
            AND trader = '$trader'
            AND marca = '$marca'
            AND linea = '$linea'
            AND producto = '$producto'
            AND gramaje = '$gramaje'
            AND ancho = '$ancho'
            AND cantidad = '$cantidad'
            AND precio = '$precio'
            AND total_item = '$total_item'
            AND fecha_produccion = '$fecha_produccion'
            AND ets = '$ets'
            AND eta = '$eta'
            AND arribo_planta = '$arribo_planta'
            AND transito = '$transito'
            AND fecha_en_planta = '$fecha_en_planta'
            AND estado = '$estado'
            AND fecha_corte = '$fecha_corte'
        ";

            $resultado = self::$db->query($queryExistente);
            if ($resultado->num_rows == 0) {
                // Insertar si no existe con esa fecha_corte
                $queryInsertar = "
                INSERT INTO " . static::$tabla . " (
                    import, proyecto, pedido_interno, fecha_solicitud, trader, marca, linea, producto,
                    gramaje, ancho, cantidad, precio, total_item, fecha_produccion, ets, eta,
                    arribo_planta, transito, fecha_en_planta, estado, fecha_corte
                ) VALUES (
                    '$import', '$proyecto', '$pedido_interno', '$fecha_solicitud', '$trader',
                    '$marca', '$linea', '$producto', '$gramaje', '$ancho', '$cantidad',
                    '$precio', '$total_item', '$fecha_produccion', '$ets', '$eta',
                    '$arribo_planta', '$transito', '$fecha_en_planta', '$estado', '$fecha_corte'
                )
            ";
                self::$db->query($queryInsertar);
            }
        }

        return true;
    }




    // EXCEL QEUJAS RECIBIDAS
    public static function procesarArchivoExcelReclamos($filePath)
    {
        ini_set('max_execution_time', 300);
        set_time_limit(300);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Crear tabla si no existe (sin la columna vendedor)
        $queryCrearTabla = "
        CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
            id INT AUTO_INCREMENT PRIMARY KEY,
            numero VARCHAR(255),
            emision DATE,
            cliente VARCHAR(255),
            codigo VARCHAR(255),
            descripcion VARCHAR(500),
            cantidad DECIMAL(10, 2),
            pvp_total DECIMAL(10, 2),
            costo DECIMAL(10, 2),
            pvp_unid DECIMAL(10, 2),
            costo_unid DECIMAL(10, 2),
            margen DECIMAL(10, 2)
        )
    ";
        self::$db->query($queryCrearTabla);

        $highestRow = $sheet->getHighestRow();

        for ($row = 2; $row <= $highestRow; $row++) {
            $data = [];
            for ($col = 'A'; $col <= 'K'; $col++) {  // A hasta K (11 columnas sin vendedor)
                $data[] = trim($sheet->getCell($col . $row)->getFormattedValue() ?? '');
            }

            // Mapeo correcto de columnas sin vendedor:
            list(
                $numero,
                $emision,
                $cliente,
                $codigo,
                $descripcion,
                $cantidad,
                $pvp_total,
                $costo,
                $pvp_unid,
                $costo_unid,
                $margen
            ) = array_map(
                fn($value) => is_numeric(str_replace(',', '.', $value)) ? str_replace(',', '.', $value) : trim($value),
                $data
            );

            if (!empty($emision) && strtotime($emision) !== false) {
                $emision = date('Y-m-d', strtotime($emision));
            } else {
                $emision = null;
            }

            $cantidad = is_numeric($cantidad) ? floatval($cantidad) : null;
            $pvp_total = is_numeric($pvp_total) ? floatval($pvp_total) : null;
            $costo = is_numeric($costo) ? floatval($costo) : null;
            $pvp_unid = is_numeric($pvp_unid) ? floatval($pvp_unid) : null;
            $costo_unid = is_numeric($costo_unid) ? floatval($costo_unid) : null;
            $margen = is_numeric($margen) ? floatval($margen) : null;

            $numero = self::$db->real_escape_string($numero);
            $cliente = self::$db->real_escape_string($cliente);
            $codigo = self::$db->real_escape_string($codigo);
            $descripcion = self::$db->real_escape_string($descripcion);

            $queryExistente = "
            SELECT id FROM " . static::$tabla . "
            WHERE numero = '$numero'
              AND emision " . ($emision ? "= '$emision'" : "IS NULL") . "
              AND cliente = '$cliente'
              AND codigo = '$codigo'
              AND descripcion = '$descripcion'
              AND cantidad = " . ($cantidad !== null ? $cantidad : "NULL") . "
              AND pvp_total = " . ($pvp_total !== null ? $pvp_total : "NULL") . "
              AND costo = " . ($costo !== null ? $costo : "NULL") . "
              AND pvp_unid = " . ($pvp_unid !== null ? $pvp_unid : "NULL") . "
              AND costo_unid = " . ($costo_unid !== null ? $costo_unid : "NULL") . "
              AND margen = " . ($margen !== null ? $margen : "NULL") . "
        ";

            $resultado = self::$db->query($queryExistente);

            if ($resultado->num_rows == 0) {
                $queryInsertar = "
                INSERT INTO " . static::$tabla . " (
                    numero, emision, cliente, codigo, descripcion,
                    cantidad, pvp_total, costo, pvp_unid, costo_unid, margen
                ) VALUES (
                    '$numero', " . ($emision ? "'$emision'" : "NULL") . ", '$cliente', '$codigo', '$descripcion',
                    " . ($cantidad !== null ? $cantidad : "NULL") . ",
                    " . ($pvp_total !== null ? $pvp_total : "NULL") . ",
                    " . ($costo !== null ? $costo : "NULL") . ",
                    " . ($pvp_unid !== null ? $pvp_unid : "NULL") . ",
                    " . ($costo_unid !== null ? $costo_unid : "NULL") . ",
                    " . ($margen !== null ? $margen : "NULL") . "
                )
            ";
                self::$db->query($queryInsertar);
            }
        }

        return true;
    }




    // ---------------------------------------------------------- EXCEL PROYECCIONES -------------------------------------------------------------------------


    // public static function procesarArchivoExcelProyecciones($filePath)
    // {
    //     $spreadsheet = IOFactory::load($filePath);
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Crear la tabla con los nuevos campos que se ven en la imagen
    //     $queryCrearTabla = "
    //         CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
    //             id INT AUTO_INCREMENT PRIMARY KEY,
    //             fecha_consumo DATE,
    //             linea VARCHAR(255),
    //             producto VARCHAR(255),
    //             gms INT,
    //             ancho INT,
    //             cantidad DECIMAL(10,2)
    //         )
    //     ";
    //     self::$db->query($queryCrearTabla);

    //     // Procesar cada fila del Excel (desde la fila 2)
    //     foreach ($sheet->getRowIterator(2) as $row) {
    //         $data = [];
    //         $cellIterator = $row->getCellIterator();
    //         $cellIterator->setIterateOnlyExistingCells(false);

    //         foreach ($cellIterator as $cell) {
    //             $data[] = trim((string)$cell->getFormattedValue());
    //         }

    //         // Validar al menos 6 columnas
    //         if (count($data) < 6) {
    //             continue;
    //         }

    //         // Mapear columnas
    //         list($fecha_consumo, $linea, $producto, $gms, $ancho, $cantidad) = array_map(function ($v) {
    //             return trim($v ?? '');
    //         }, $data);

    //         // Convertir valores numéricos
    //         $gms = intval($gms);
    //         $ancho = intval($ancho);
    //         $cantidad = floatval(str_replace(',', '.', $cantidad));

    //         // Insertar en la base de datos
    //         $queryInsertar = "
    //             INSERT INTO " . static::$tabla . " (
    //                 fecha_consumo, linea, producto, gms, ancho, cantidad
    //             ) VALUES (
    //                 '" . self::$db->real_escape_string($fecha_consumo) . "',
    //                 '" . self::$db->real_escape_string($linea) . "',
    //                 '" . self::$db->real_escape_string($producto) . "',
    //                 $gms,
    //                 $ancho,
    //                 $cantidad
    //             )
    //         ";
    //         self::$db->query($queryInsertar);
    //     }

    //     return true;
    // }




    public static function procesarArchivoExcelProyecciones($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Crear tabla si no existe
        $queryCrearTabla = "
        CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
            id INT AUTO_INCREMENT PRIMARY KEY,
            fecha_consumo DATE,
            linea VARCHAR(255),
            producto VARCHAR(255),
            gms INT,
            ancho INT,
            cantidad DECIMAL(10,2)
        )
    ";
        self::$db->query($queryCrearTabla);

        foreach ($sheet->getRowIterator(2) as $row) {
            $data = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            foreach ($cellIterator as $cell) {
                $data[] = trim((string)$cell->getFormattedValue());
            }

            if (count($data) < 6) {
                continue;
            }

            list($fecha_consumo, $linea, $producto, $gms, $ancho, $cantidad) = array_map(function ($v) {
                return trim($v ?? '');
            }, $data);

            $gms = intval($gms);
            $ancho = intval($ancho);
            $cantidad = floatval(str_replace(',', '.', $cantidad));

            // Verifica si ya existe un registro con los mismos datos y mes
            $mes = date('Y-m', strtotime($fecha_consumo));
            $checkQuery = "
            SELECT COUNT(*) as total FROM " . static::$tabla . "
            WHERE DATE_FORMAT(fecha_consumo, '%Y-%m') = '" . self::$db->real_escape_string($mes) . "'
              AND linea = '" . self::$db->real_escape_string($linea) . "'
              AND producto = '" . self::$db->real_escape_string($producto) . "'
              AND gms = $gms
              AND ancho = $ancho
              AND cantidad = $cantidad
        ";
            $result = self::$db->query($checkQuery);
            $rowExists = $result->fetch_assoc();

            if ((int)$rowExists['total'] === 0) {
                // Insertar solo si no existe
                $queryInsertar = "
                INSERT INTO " . static::$tabla . " (
                    fecha_consumo, linea, producto, gms, ancho, cantidad
                ) VALUES (
                    '" . self::$db->real_escape_string($fecha_consumo) . "',
                    '" . self::$db->real_escape_string($linea) . "',
                    '" . self::$db->real_escape_string($producto) . "',
                    $gms,
                    $ancho,
                    $cantidad
                )
            ";
                self::$db->query($queryInsertar);
            }
        }

        return true;
    }








    public static function obtenerPaginado($limite, $offset)
    {
        $sql = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT {$limite} OFFSET {$offset}";
        return self::consultarSQL($sql);
    }


    // necesito contar cuantos registros hay en la tabla
    public static function contarRegistros()
    {
        $sql = "SELECT COUNT(*) as total FROM " . static::$tabla;
        $resultado = self::$db->query($sql);
        $fila = $resultado->fetch_assoc();
        return $fila['total'];
    }










    // excel de pedidos 
    public static function procesarArchivoExcelpedidos($filePath)
    {
        // Cargar el archivo Excel
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Crear la tabla con los nuevos campos que se ven en la imagen
        $queryCrearTabla = "
        CREATE TABLE IF NOT EXISTS " . static::$tabla . " (
            id INT AUTO_INCREMENT PRIMARY KEY,
            numero_pedido VARCHAR(255),
            nombre_pedido VARCHAR(255),
            cantidad INT,
            largo INT,
            ancho INT,
            alto INT,
            flauta VARCHAR(255),
            test INT,
            fecha_ingreso DATE,
            fecha_entrega DATE
        )
    ";
        // Ejecutar la consulta para crear la tabla
        if (!self::$db->query($queryCrearTabla)) {
            echo "Error al crear la tabla: " . self::$db->error;
            return false;
        }

        // Procesar cada fila del Excel (desde la fila 2)
        foreach ($sheet->getRowIterator(2) as $row) {
            $data = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            // Recoger todos los valores de las celdas en la fila
            foreach ($cellIterator as $cell) {
                $data[] = trim((string)$cell->getFormattedValue());
            }

            // Validar que haya al menos 11 columnas
            if (count($data) < 10) {
                continue;  // Ignorar filas con menos de 11 columnas
            }

            // Mapear las columnas con el orden adecuado
            list($numero_pedido, $nombre_pedido, $cantidad, $largo, $ancho, $alto, $flauta, $test, $fecha_ingreso, $fecha_entrega) = array_map(function ($v) {
                return trim($v ?? '');
            }, $data);

            // Convertir los valores a los tipos correspondientes
            $cantidad = intval($cantidad);
            $largo = intval($largo);
            $ancho = intval($ancho);
            $alto = intval($alto);
            $test = intval($test);

            // Insertar los datos en la base de datos
            $queryInsertar = "
            INSERT INTO " . static::$tabla . " (
                numero_pedido, nombre_pedido, cantidad, largo, ancho, alto, flauta, test, fecha_ingreso, fecha_entrega
            ) VALUES (
                '" . self::$db->real_escape_string($numero_pedido) . "',
                '" . self::$db->real_escape_string($nombre_pedido) . "',
                $cantidad,
                $largo,
                $ancho,
                $alto,
                '" . self::$db->real_escape_string($flauta) . "',
                $test,
                '" . self::$db->real_escape_string($fecha_ingreso) . "',
                '" . self::$db->real_escape_string($fecha_entrega) . "'
            )
        ";

            // Ejecutar la consulta de inserción y manejar errores
            if (!self::$db->query($queryInsertar)) {
                echo "Error en la consulta de inserción: " . self::$db->error . "\n";
            }
        }

        return true;
    }




    // ---------------------------------------------------------------------------------------------------------------------------------------------------------------------




    // Actualizar el registro
    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .=  join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar()
    {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function eliminarTabla()
    {
        $query = "DROP TABLE " . static::$tabla;
        $resultado = self::$db->query($query);
        return $resultado;
    }


    // Busqueda todos los registros que pertenecen a un id
    public static function belongsTo($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }




    // invetario de materia prima de sistemas 

    public static function allSis($id, $orden = 'DESC')
    {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id_{$id} {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function findSis($id)
    {
        $query = "SELECT * FROM " . static::$tabla  . " WHERE id_producto= {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }



    public static function countinventario()
    {
        // Construye la consulta base sin filtro
        $query = "SELECT COUNT(*) as total FROM " . static::$tabla;

        // Ejecuta la consulta y obtiene el resultado
        $resultado = self::consultarSQL1($query);

        // Devuelve el total si existe en el resultado
        if (is_array($resultado) && isset($resultado[0]['total'])) {
            return (int) $resultado[0]['total'];
        }

        return 0;
    }


    public static function countTicketsAbiertos()
    {
        $query = "SELECT COUNT(*) as total FROM " . static::$tabla . " WHERE estado = 'abierto'";

        $resultado = self::consultarSQL1($query);

        if (is_array($resultado) && isset($resultado[0]['total'])) {
            return (int) $resultado[0]['total'];
        }

        return 0;
    }

    public static function countTicketsCerrados()
    {
        $query = "SELECT COUNT(*) as total FROM " . static::$tabla . " WHERE estado = 'cerrado'";

        $resultado = self::consultarSQL1($query);

        if (is_array($resultado) && isset($resultado[0]['total'])) {
            return (int) $resultado[0]['total'];
        }

        return 0;
    }



    public static function countTicketsPendientesHoy($fechaCreacion)
    {
        // Extraer solo la fecha (sin hora) de la fecha de creación recibida
        $fecha = date('Y-m-d', strtotime($fechaCreacion));

        $query = "SELECT COUNT(*) as total 
              FROM " . static::$tabla . " 
              WHERE estado = 'pendiente' 
              AND DATE(fecha_creacion) = '{$fecha}'
              AND fecha_creacion <= '{$fechaCreacion}'";

        $resultado = self::consultarSQL1($query);

        if (is_array($resultado) && isset($resultado[0]['total'])) {
            return (int) $resultado[0]['total'];
        }

        return 0;
    }


    // recuperar codigo 
    public static function whereCodigo($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '" . self::$db->escape_string($valor) . "'";
        $resultado = self::consultarSQL($query);
        return $resultado; // Devuelve array con todos los objetos encontrados
    }
}
