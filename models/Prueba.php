<?php

namespace Model;

use DateTime;

class Prueba extends ActiveRecord
{
    protected static $tabla = 'control_empaque';
    protected static $columnasDB = ['id', 'fecha', 'turno', 'personal', 'producto', 'medidas', 'cantidad', 'hora_inicio', 'hora_fin', 'total_horas', 'x_hora','horas_trabajo'];


    public ?int $id;
    public string $fecha = '';
    public string $turno = '';
    // public array $personal = [];
    // En Model\Prueba.php
    public string $personal;

    public string $producto = '';
    public string $medidas = '';
    public string $cantidad = '';
    public string $hora_inicio = '';
    public string $hora_fin = '';
    public string $total_horas = '';
    public string $x_hora = '';
    public string $horas_trabajo = '';





    public function __construct(array $args = [])
    {
                date_default_timezone_set('America/Guayaquil');

        $this->id = $args['id'] ?? null;
        $this->fecha = date('Y-m-d');
        $this->turno = $args['turno'] ?? '';
        // $this->personal = $args['personal'] ?? [];


        // Si viene como array (desde formulario), convertir a string
        // if (isset($args['personal'])) {
        //     if (is_array($args['personal'])) {
        //         $this->personal = $args['personal'];
        //     } else {
        //         $this->personal = [$args['personal']]; // Asegurarse de que sea un array
        //     }
        // } else {
        //     $this->personal = [];
        // }


        $this->producto = $args['producto'] ?? '';
        $this->medidas = $args['medidas'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->hora_inicio = $args['hora_inicio'] ?? '';
        $this->hora_fin = $args['hora_fin'] ?? '';
        $this->total_horas = $args['total_horas'] ?? '';
        $this->x_hora = $args['x_hora'] ?? '';
        $this->horas_trabajo = $args['horas_trabajo'] ?? '';
    }



    public function validar(): array
    {
        if (!$this->fecha) {
            self::$alertas['error'][] = 'La Fecha es Obligatoria';
        }
        if (!$this->turno) {
            self::$alertas['error'][] = 'El Turno es Obligatorio';
        }

        if (!$this->producto) {
            self::$alertas['error'][] = 'El Producto es Obligatorio';
        }
        // if (!$this->medidas) {
        //     self::$alertas['error'][] = 'La Medida es Obligatoria';
        // }
        // if (!$this->cantidad) {
        //     self::$alertas['error'][] = 'La Cantidad es Obligatoria';
        // }
        // if (!$this->hora_inicio) {
        //     self::$alertas['error'][] = 'La Hora de Inicio es Obligatoria';
        // }
        // if (!$this->hora_fin) {
        //     self::$alertas['error'][] = 'La Hora de Fin es Obligatoria';
        // }
        // if (!$this->total_horas) {
        //     self::$alertas['error'][] = 'El Total de Horas es Obligatorio';
        // }
        return self::$alertas;
    }



    public function sacarTotalHoras()
    {
        $inicio = new DateTime($this->hora_inicio);
        $fin = new DateTime($this->hora_fin);
        $diferencia = $inicio->diff($fin);
        $this->total_horas = $diferencia->h + ($diferencia->i / 60);
    }
}
