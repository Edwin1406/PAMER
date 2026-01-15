<?php 
namespace Model;




class CambiosTurno extends ActiveRecord {

    protected static $tabla = 'cambios_diseno_turno';
    protected static $columnasDB = ['id', 'id_turno','codigo','cambios','estado','fecha_creacion','fecha_entrega'];

    public $id;
    public $id_turno;
    public $codigo;
    public $cambios;
    public $estado;
    public $fecha_creacion;
    public $fecha_entrega;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_turno = $args['id_turno'] ?? null;
        $this->codigo = $args['codigo'] ?? null;
        $this->cambios = $args['cambios'] ?? null;
        $this->estado = $args['estado'] ?? 'PENDIENTE';
        $this->fecha_creacion = $args['fecha_creacion'] ?? null;
        $this->fecha_entrega = $args['fecha_entrega'] ?? null;
    }

    public function validarCambios(): array
    {
        if(!$this->id_turno) {
            self::$alertas['error'][] = 'El Campo ID Turno es Obligatorio';
        }
        if(!$this->codigo) {
            self::$alertas['error'][] = 'El Campo Código es Obligatorio';
        }
        if(!$this->cambios) {
            self::$alertas['error'][] = 'El Campo Cambios es Obligatorio';
        }
        if(!$this->fecha_creacion) {
            self::$alertas['error'][] = 'El Campo Fecha de Creación es Obligatorio';
        }
        if(!$this->fecha_entrega) {
            self::$alertas['error'][] = 'El Campo Fecha de Entrega es Obligatorio';
        }
        return self::$alertas;
    }





















}
