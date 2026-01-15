<?php 
namespace Model;



class Diseno extends ActiveRecord {

    protected static $tabla = 'visor';
    protected static $columnasDB = ['id','fecha','nombre_cliente','proveedor','nombre_producto','codigo_producto','estado','pdf'];

    public $id;
    public $fecha;
    public $nombre_cliente;
    public $proveedor; // Agregar la propiedad proveedor
    public $nombre_producto;
    public $codigo_producto;
    public $estado;
    public $pdf;
    // public $pdf_actual; // Definir la propiedad explícitamente


    public function __construct($args = [])
    {
         date_default_timezone_set('America/Guayaquil');
        $fecha = date('Y-m-d H:i:s'); 
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? $fecha;
        // quitar espacios en blanco
        $this->nombre_cliente = isset($args['nombre_cliente']) ? trim($args['nombre_cliente']) : '';
        // $this->nombre_cliente = $args['nombre_cliente'] ?? '';
        $this->proveedor = $args['proveedor'] ?? ''; // Inicializar la propiedad proveedor
        $this->nombre_producto = $args['nombre_producto'] ?? '';
        $this->codigo_producto = $args['codigo_producto'] ?? '';
        $this->estado = $args['estado'] ?? 'ENVIADO';
    }

    



    public function validar() {

        if(!$this->nombre_cliente) {
            self::$alertas['error'][] = 'El Campo Nombre Cliente es Obligatorio';
        }

        if(!$this->nombre_producto) {
            self::$alertas['error'][] = 'El Campo Nombre producto es Obligatorio';
        }

        if(!$this->codigo_producto) {
            self::$alertas['error'][] = 'El Campo Codigo Producto es Obligatorio';
        }

        // if(!$this->pdf && !$this->id) {
        //     self::$alertas['error'][] = 'El Campo PDF es Obligatorio';
        // }
       
        return self::$alertas;
    }


} 