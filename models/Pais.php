<?php 
namespace Model;


class Pais extends ActiveRecord {

    protected static $tabla = 'ORIGEN';
    protected static $columnasDB = ['id', 'Pais_Origen'];

    public $id;
    public $Pais_Origen;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->Pais_Origen = $args['Pais_Origen'] ?? '';
   
    }


    public function validar() {

        if(!$this->Pais_Origen) {
            self::$alertas['error'][] = 'El Campo Pais Origen es Obligatorio';

        }
       
        return self::$alertas;
    }





}