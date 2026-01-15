<?php 
namespace Model;


class Bodega extends ActiveRecord {

    protected static $tabla = 'BODEGA';
    protected static $columnasDB = ['id', 'Nombre_Bodega','Sigla_Bodega'];

    public $id;
    public $Nombre_Bodega;
    public $Sigla_Bodega;
    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->Nombre_Bodega = $args['Nombre_Bodega'] ?? '';
        $this->Sigla_Bodega = $args['Sigla_Bodega'] ?? '';
    }


    public function validar() {

        if(!$this->Nombre_Bodega) {
            self::$alertas['error'][] = 'El Campo Nombre Bodega es Obligatorio';
            
        }

        if(!$this->Sigla_Bodega) {
            self::$alertas['error'][] = 'El Campo Sigla Bodega es Obligatorio';
        }
       
        return self::$alertas;
    }





}