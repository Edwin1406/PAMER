<?php 
namespace Model;

class Carrito extends ActiveRecord {

    protected static $tabla = 'carrito';
    protected static $columnasDB = [
        'id',

        'Codigo_Nota_Pedido',
        'Nombre_Tienda',
        'Fecha_Tienda_Nota_Pedido',
        'Factura_Nota_Pedido',
        'Total_Tienda_Nota_Pedido',
        'cantidad'
    ];

    public $id;
        public $Codigo_Nota_Pedido;
    public $Nombre_Tienda;
    public $Fecha_Tienda_Nota_Pedido;
    public $Factura_Nota_Pedido;
    public $Total_Tienda_Nota_Pedido;
    public $cantidad;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->Codigo_Nota_Pedido = $args['Codigo_Nota_Pedido'] ?? null;
        $this->Nombre_Tienda = $args['Nombre_Tienda'] ?? '';
        $this->Fecha_Tienda_Nota_Pedido = $args['Fecha_Tienda_Nota_Pedido'] ?? null;
        $this->Factura_Nota_Pedido = $args['Factura_Nota_Pedido'] ?? null;
        $this->Total_Tienda_Nota_Pedido = $args['Total_Tienda_Nota_Pedido'] ?? 0.00;
        $this->cantidad = $args['cantidad'] ?? 0;
    }
}
