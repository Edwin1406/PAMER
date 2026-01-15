<?php

namespace Model;

use DateTime;

class Ventas extends ActiveRecord
{
    // Table
    protected static $tabla = 'VENTAS';

    // Columns as they appear in MySQL (respect exact names)
    protected static $columnasDB = [
        'id',
        'Codigo_Nota_Pedido',
        'Cantidad_Compra',
        'Etiqueta_Compra',
        'Estilo_Compra',
        'Prenda_Compra',
        'Composicion_Compra',
        'Tienda_Compra',
        'Marca_Compra',
        'Origen_Compra',
        'Precio_Compra',
        'Bodega_Compra',
        'Caja_Compra',
        'Factura_Compra',
        'Precio_Total_Compra',   // <- renamed column
        'fecha'
    ];

    // Public props (typed as reasonably as possible)
    public ?int $id;
    public ?int $Codigo_Nota_Pedido;
    public ?int $Cantidad_Compra;
    public ?int $Etiqueta_Compra;
    public ?string $Estilo_Compra;
    public ?string $Prenda_Compra;
    public ?string $Composicion_Compra;
    public ?string $Tienda_Compra;
    public ?string $Marca_Compra;
    public ?string $Origen_Compra;
    public ?float $Precio_Compra;
    public ?string $Bodega_Compra;
    public ?int $Caja_Compra;
    public ?int $Factura_Compra;
    public ?float $Precio_Total_Compra; // <- was $total
    public ?string $fecha;              // column type is DATE (no time)

    public function __construct(array $args = [])
    {
        // If the column is DATE (not DATETIME), save only Y-m-d
        date_default_timezone_set('America/Guayaquil');
        $hoy = date('Y-m-d');

        $this->id                   = $args['id']                   ?? null;
        $this->Codigo_Nota_Pedido   = $args['Codigo_Nota_Pedido']   ?? null;
        $this->Cantidad_Compra      = $args['Cantidad_Compra']      ?? null;
        $this->Etiqueta_Compra      = $args['Etiqueta_Compra']      ?? null;
        $this->Estilo_Compra        = $args['Estilo_Compra']        ?? null;
        $this->Prenda_Compra        = $args['Prenda_Compra']        ?? null;
        $this->Composicion_Compra   = $args['Composicion_Compra']   ?? null;
        $this->Tienda_Compra        = $args['Tienda_Compra']        ?? null;
        $this->Marca_Compra         = $args['Marca_Compra']         ?? null;
        $this->Origen_Compra        = $args['Origen_Compra']        ?? null;
        $this->Precio_Compra        = isset($args['Precio_Compra']) ? (float)$args['Precio_Compra'] : null;
        $this->Bodega_Compra        = $args['Bodega_Compra']        ?? null;
        $this->Caja_Compra          = $args['Caja_Compra']          ?? null;
        $this->Factura_Compra       = $args['Factura_Compra']       ?? null;
        $this->Precio_Total_Compra  = isset($args['Precio_Total_Compra']) ? (float)$args['Precio_Total_Compra'] : null;
        $this->fecha                = $args['fecha']                ?? $hoy;
    }
}
