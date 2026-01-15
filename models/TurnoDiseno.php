<?php

namespace Model;

use DateTime;

class TurnoDiseno extends ActiveRecord
{
    protected static $tabla = 'turno_diseno';
    protected static $columnasDB = [
        'id',
        'codigo',
        'tipo_producto',
        'tipo_componente',
        'largo',
        'alto',
        'ancho',
        'dobles',
        'descripcion',
        'flauta',
        'material',
        'ect',
        'vendedor',
        'observaciones',
        'colores',
        'pdf',
        'estado',
        'fecha_creacion',
        'fecha_entrega'
    ];

    public ?int $id;
    public ?string $codigo;
    public ?string $tipo_producto;
    public ?string $tipo_componente;
    public  $largo;
    public  $alto;
    public  $ancho;
    public ?string $dobles;
    public ?string $descripcion;
    public ?string $flauta;
    public ?string $material;
    public  $ect;
    public ?string $vendedor;
    public ?string $observaciones;
    public ?string $colores;
    public ?string $pdf;
    public ?string $estado;
    public ?string $fecha_creacion;
    public ?string $fecha_entrega;


    public function __construct(array $args = [])
    {
        // FECHA ATOMATICA GAYAQUIL/ECUADOR
        date_default_timezone_set('America/Guayaquil');

        $this->id = $args['id'] ?? null;
        $this->codigo = $args['codigo'] ?? null;
        $this->tipo_producto = $args['tipo_producto'] ?? null;
        $this->tipo_componente = $args['tipo_componente'] ?? null;
        $this->largo = $args['largo'] ?? null;
        $this->alto = $args['alto'] ?? null;
        $this->ancho = $args['ancho'] ?? null;
        $this->dobles = $args['dobles'] ?? null;
        $this->descripcion = $args['descripcion'] ?? null;
        $this->flauta = $args['flauta'] ?? null;
        $this->material = $args['material'] ?? null;
        $this->ect = $args['ect'] ?? null;
        $this->vendedor = $args['vendedor'] ?? null;
        $this->observaciones = $args['observaciones'] ?? null;
        $this->colores = $args['colores'] ?? null;
        $this->pdf = $args['pdf'] ?? null;
        $this->estado = $args['estado'] ?? 'PENDIENTE'; // Default state
        $this->fecha_creacion = date('Y-m-d H:i:s');
        $this->fecha_entrega = $args['fecha_entrega'] ?? null;
    }


    // validar


    public function validar(): array
    {
        // if (!$this->codigo) {
        //     self::$alertas['error'][] = 'El código es obligatorio';
        // }
        if (!$this->tipo_producto) {
            self::$alertas['error'][] = 'El tipo de producto es obligatorio';
        }
        if (!$this->tipo_componente) {
            self::$alertas['error'][] = 'El tipo de componente es obligatorio';
        }

        if (!$this->pdf) {
            self::$alertas['error'][] = 'El PDF es obligatorio';
        }

        if (!$this->vendedor) {
            self::$alertas['error'][] = 'El vendedor es obligatorio';
        }
        return self::$alertas;
    }
}
