<?php

namespace Model;

use DateTime;

class HorasTrabajo extends ActiveRecord {    
    protected static $tabla = 'horas_trabajo';
    protected static $columnasDB = ['id','hora_trabajo','fecha'];

    public  $id;
    public  $hora_trabajo;
    public  $fecha;
    


    public function __construct($args = [])

    // fecha automatica
    
    {

         date_default_timezone_set('America/Guayaquil');
        $fecha = date('Y-m-d');
        $this->id = $args['id'] ?? null;
        $this->hora_trabajo = $args['hora_trabajo'] ?? null;
        // $this->fecha = $args['fecha'] ?? null;
        $this->fecha = $fecha;
    }

















}