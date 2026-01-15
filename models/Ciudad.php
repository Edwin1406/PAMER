<?php 
namespace Model;


class Ciudad extends ActiveRecord {

    protected static $tabla = 'CIUDAD';
    protected static $columnasDB = ['id', 'Nombre_Ciudad','Sigla_Ciudad'];

    public $id;
    public $Nombre_Ciudad;
    public $Sigla_Ciudad;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->Nombre_Ciudad = $args['Nombre_Ciudad'] ?? '';
        $this->Sigla_Ciudad = $args['Sigla_Ciudad'] ?? '';
    }


    public function validar() {

        if(!$this->Nombre_Ciudad) {
            self::$alertas['error'][] = 'El Campo Nombre Ciudad es Obligatorio';

        }

        if(!$this->Sigla_Ciudad) {
            self::$alertas['error'][] = 'El Campo Sigla Ciudad es Obligatorio';
        }
       
        return self::$alertas;
    }

}