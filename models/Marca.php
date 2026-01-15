<?php 
namespace Model;


class Marca extends ActiveRecord {

    protected static $tabla = 'MARCA';
    protected static $columnasDB = ['id', 'Nombre_Marca'];

    public $id;
    public $Nombre_Marca;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->Nombre_Marca = $args['Nombre_Marca'] ?? '';
    }


    public function validar() {

        if(!$this->Nombre_Marca) {
            self::$alertas['error'][] = 'El Campo Nombre Marca es Obligatorio';
        }
        return self::$alertas;
    }

}