<?php 
namespace Model;

class Tienda extends ActiveRecord {

    protected static $tabla = 'TIENDA';
    protected static $columnasDB = [
        'id',
        'Codigo_Tienda',
        'Nombre_Tienda',
        'Direccion_Tienda',
        'Telefono_Tienda',
        'Telefono1_Tienda',
        'Fax_Tienda',
        'Email_Tienda',
        'Ciudad_Tienda',
        'Pais_Tienda',
        'Contacto_Tienda',
        'Tipo_Tienda',
        'Foto_Tienda'
    ];

    public $id;
    public $Codigo_Tienda;
    public $Nombre_Tienda;
    public $Direccion_Tienda;
    public $Telefono_Tienda;
    public $Telefono1_Tienda;
    public $Fax_Tienda;
    public $Email_Tienda;
    public $Ciudad_Tienda;
    public $Pais_Tienda;
    public $Contacto_Tienda;
    public $Tipo_Tienda;
    public $Foto_Tienda;

    public function __construct($args = [])
    {
        $this->id               = $args['id'] ?? null;
        $this->Codigo_Tienda   = $args['Codigo_Tienda'] ?? null;
        $this->Nombre_Tienda   = $args['Nombre_Tienda'] ?? '';
        $this->Direccion_Tienda= $args['Direccion_Tienda'] ?? '';
        $this->Telefono_Tienda = $args['Telefono_Tienda'] ?? '';
        $this->Telefono1_Tienda= $args['Telefono1_Tienda'] ?? '';
        $this->Fax_Tienda      = $args['Fax_Tienda'] ?? '';
        $this->Email_Tienda    = $args['Email_Tienda'] ?? '';
        $this->Ciudad_Tienda   = $args['Ciudad_Tienda'] ?? '';
        $this->Pais_Tienda     = $args['Pais_Tienda'] ?? '';
        $this->Contacto_Tienda = $args['Contacto_Tienda'] ?? '';
        $this->Tipo_Tienda     = $args['Tipo_Tienda'] ?? '';
        $this->Foto_Tienda     = $args['Foto_Tienda'] ?? '';
    }

    public function validar() {
        if(!$this->Nombre_Tienda) {
            self::$alertas['error'][] = 'El Campo Nombre de la Tienda es Obligatorio';
        }

        if(!$this->Tipo_Tienda) {
            self::$alertas['error'][] = 'El Campo Tipo de Tienda es Obligatorio';
        }

        if(!$this->Pais_Tienda) {
            self::$alertas['error'][] = 'El Campo País de Tienda es Obligatorio';
        }

        return self::$alertas;
    }
}
