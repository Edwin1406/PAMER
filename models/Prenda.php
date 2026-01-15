<?php 
namespace Model;

class Prenda extends ActiveRecord {

    protected static $tabla = 'PRENDA';
    protected static $columnasDB = [
        'id',
        'Prenda_Partida',
        'Partida_Partida',
        'Composicion_Partida',
    ];

    public $id;
    public $Prenda_Partida;
    public $Partida_Partida;
    public $Composicion_Partida;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->Prenda_Partida = $args['Prenda_Partida'] ?? null;
        $this->Partida_Partida = $args['Partida_Partida'] ?? null;
        $this->Composicion_Partida = $args['Composicion_Partida'] ?? null;
    }
}
