<?php

namespace Model;

use DateTime;

class Detalle_compra extends ActiveRecord
{
    // Nombre de la tabla en la base de datos
    protected static $tabla = 'DETALLE_COMPRA';

    // Columnas exactas según la estructura MySQL del screenshot
    protected static $columnasDB = [
        'id',
        'Codigo_Nota_Pedido',
        'etiqueta',
        'prenda',
        'partida',
        'composicion',
        'cantidad',
        'precio_unitario',
        'total',
        'num_factura',
        'tienda',
        'marca',
        'pais',
        'num_caja',
        'bodega'
    ];


    public $id;
    public $Codigo_Nota_Pedido;
    public $etiqueta;
    public $prenda;
    public $partida;
    public $composicion;
    public $cantidad;
    public $precio_unitario;
    public $total;
    public $num_factura;
    public $tienda;
    public $marca;
    public $pais;
    public $num_caja;
    public $bodega;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->Codigo_Nota_Pedido = $args['Codigo_Nota_Pedido'] ?? null;
        $this->etiqueta = $args['etiqueta'] ?? null;
        $this->prenda = $args['prenda'] ?? null;
        $this->partida = $args['partida'] ?? null;
        $this->composicion = $args['composicion'] ?? null;
        $this->cantidad = $args['cantidad'] ?? 0;
        $this->precio_unitario = $args['precio_unitario'] ?? 0.0;
        $this->total = $args['total'] ?? 0.0;
        $this->num_factura = $args['num_factura'] ?? null;
        $this->tienda = $args['tienda'] ?? null;
        $this->marca = $args['marca'] ?? null;
        $this->pais = $args['pais'] ?? null;
        $this->num_caja = $args['num_caja'] ?? null;
        $this->bodega = $args['bodega'] ?? null;

    }



    
}
