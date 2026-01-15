<?php 
namespace Model;

class Exportadores extends ActiveRecord {

    protected static $tabla = 'EXPORTADORES';
    protected static $columnasDB = ['id', 'Codigo_Exp', 'Nombre_Exportador', 'Direccion_Exportador', 'Ciudad_Exp', 'Ruc_Exporte', 'Foto_Exportador'];

    public $id;
    public $Codigo_Exp;
    public $Nombre_Exportador;
    public $Direccion_Exportador;
    public $Ciudad_Exp;
    public $Ruc_Exporte;
    public $Foto_Exportador;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->Codigo_Exp = $args['Codigo_Exp'] ?? '';
        $this->Nombre_Exportador = $args['Nombre_Exportador'] ?? '';
        $this->Direccion_Exportador = $args['Direccion_Exportador'] ?? '';
        $this->Ciudad_Exp = $args['Ciudad_Exp'] ?? '';
        $this->Ruc_Exporte = $args['Ruc_Exporte'] ?? '';
        $this->Foto_Exportador = $args['Foto_Exportador'] ?? '';
    }

    public function validar() {

        if(!$this->Codigo_Exp) {
            self::$alertas['error'][] = 'El Campo Código Exportador es Obligatorio';
        }

        if(!$this->Nombre_Exportador) {
            self::$alertas['error'][] = 'El Campo Nombre Exportador es Obligatorio';
        }

        if(!$this->Direccion_Exportador) {
            self::$alertas['error'][] = 'El Campo Dirección Exportador es Obligatorio';
        }

        if(!$this->Ciudad_Exp) {
            self::$alertas['error'][] = 'El Campo Ciudad Exportador es Obligatorio';
        }

        if(!$this->Ruc_Exporte) {
            self::$alertas['error'][] = 'El Campo Ruc Exportador es Obligatorio';
        }

        if(!$this->Foto_Exportador) {
            self::$alertas['error'][] = 'El Campo Foto Exportador es Obligatorio';
        }

        return self::$alertas;
    }
}
