<?php 
namespace Model;


class Importadores extends ActiveRecord {

    protected static $tabla = 'IMPORTADORES';
    protected static $columnasDB = ['id', 'Nombre_Importador','Direccion_inv','Ciudad_Imp','Ruc_Import','Telefono_Inv','Pais_Import'];

    public $id;
    public $Nombre_Importador;
    public $Direccion_inv;
    public $Ciudad_Imp;
    public $Ruc_Import;
    public $Telefono_Inv;
    public $Pais_Import;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->Nombre_Importador = $args['Nombre_Importador'] ?? '';
        $this->Direccion_inv = $args['Direccion_inv'] ?? '';
        $this->Ciudad_Imp = $args['Ciudad_Imp'] ?? '';
        $this->Ruc_Import = $args['Ruc_Import'] ?? '';
        $this->Telefono_Inv = $args['Telefono_Inv'] ?? '';
        $this->Pais_Import = $args['Pais_Import'] ?? '';
    }



    public function validar() {

        if(!$this->Nombre_Importador) {
            self::$alertas['error'][] = 'El Campo Nombre Importador es Obligatorio';
            
        }

        if(!$this->Direccion_inv) {
            self::$alertas['error'][] = 'El Campo Direccion Importador es Obligatorio';
        }

        if(!$this->Ciudad_Imp) {
            self::$alertas['error'][] = 'El Campo Ciudad Importador es Obligatorio';
        }

        if(!$this->Ruc_Import) {
            self::$alertas['error'][] = 'El Campo Ruc Importador es Obligatorio';
        }

        if(!$this->Telefono_Inv) {
            self::$alertas['error'][] = 'El Campo Telefono Importador es Obligatorio';
        }

        if(!$this->Pais_Import) {
            self::$alertas['error'][] = 'El Campo Pais Importador es Obligatorio';
        }
       return self::$alertas;
    }




}
