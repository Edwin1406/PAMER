<?php 
namespace Model;

class TiendaNota extends ActiveRecord {

    protected static $tabla = 'picos_nota';
    protected static $columnasDB = [
        'id',
        'Codigo_Nota_Pedido',
        'tienda',
        'marca',
        'ciudad',
        'pais',
        'fecha',
        'num_factura'
    ];

    public $id;
    public $Codigo_Nota_Pedido;
    public $tienda;
    public $marca;
    public $ciudad;
    public $pais;
    public $fecha;
    public $num_factura;
    


    public function __construct($args = [])
    {
        $this->id               = $args['id'] ?? null;
        $this->Codigo_Nota_Pedido= $args['Codigo_Nota_Pedido'] ?? null;
        $this->tienda           = $args['tienda'] ?? '';
        $this->marca            = $args['marca'] ?? '';
        $this->ciudad          = $args['ciudad'] ?? '';
        $this->pais            = $args['pais'] ?? '';
        $this->fecha          = $args['fecha'] ?? '';
        $this->num_factura    = $args['num_factura'] ?? '';
    }

    public function validar() {

        if($this->Codigo_Nota_Pedido == null) {
            self::$alertas['error'][] = 'El Campo Codigo Nota Pedido es Obligatorio';

        }



        if(!$this->tienda) {
            self::$alertas['error'][] = 'El Campo Tienda es Obligatorio';

        }

        if(!$this->ciudad) {
            self::$alertas['error'][] = 'El Campo Ciudad es Obligatorio';

        }

        if(!$this->pais) {
            self::$alertas['error'][] = 'El Campo Pais es Obligatorio';

        }

        if(!$this->num_factura) {
            self::$alertas['error'][] = 'El Campo Numero de Factura es Obligatorio';

        }

        if(!$this->marca) {
            self::$alertas['error'][] = 'El Campo Marca es Obligatorio';

        }



        if(!$this->fecha) {
            self::$alertas['error'][] = 'El Campo Fecha es Obligatorio';
        }






        return self::$alertas;
    }
}
