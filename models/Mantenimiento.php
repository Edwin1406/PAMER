<?php 
namespace Model;
class Mantenimiento extends ActiveRecord {
    protected static $tabla = 'mantenimiento_bodega';

    protected static $columnasDB = [
        'id',
        'fecha',
        'tipo_doc',
        'numero',
        'proveedor',
        'maquina',
        'trabajo',
        'valor',
        'descuento',
        'subtotal',
        'iva',
        'total',
        'observacion'
    ];

    public $id;
    public $fecha;
    public $tipo_doc;
    public $numero;
    public $proveedor;
    public $maquina;
    public $trabajo;
    public $valor;
    public $descuento;
    public $subtotal;
    public $iva;
    public $total;
    public $observacion;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->tipo_doc = $args['tipo_doc'] ?? '';
        $this->numero = $args['numero'] ?? '';
        $this->proveedor = $args['proveedor'] ?? '';
        $this->maquina = $args['maquina'] ?? '';
        $this->trabajo = $args['trabajo'] ?? '';
        $this->valor = $args['valor'] ?? 0;
        $this->descuento = $args['descuento'] ?? 0;
        $this->subtotal = $args['subtotal'] ?? 0;
        $this->iva = $args['iva'] ?? 0;
        $this->total = $args['total'] ?? 0;
        $this->observacion = $args['observacion'] ?? '';
    }






}

