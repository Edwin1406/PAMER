<?php

namespace Model;

use DateTime;

class DetalleEmpaque extends ActiveRecord {    
    protected static $tabla = 'tabla_resumen';
    protected static $columnasDB = ['id','persona','horas_efectivas','registros','tiempo_muerto'];

    public $id;
    public $persona;
    public $horas_efectivas;
    public $registros;
    public $tiempo_muerto;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->persona = $data['persona'] ?? null;
        $this->horas_efectivas = $data['horas_efectivas'] ?? null;
        $this->registros = $data['registros'] ?? null;
        $this->tiempo_muerto = $data['tiempo_muerto'] ?? null;
    }





}



