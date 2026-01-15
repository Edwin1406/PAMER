<?php

namespace Model;

use DateTime;

class Compra extends ActiveRecord
{
    // Nombre de la tabla en la base de datos
    protected static $tabla = 'COMPRA';

    // Columnas exactas según la estructura MySQL
    protected static $columnasDB = [
        'id',
        'Codigo_Nota_Pedido',
        'Fecha_Nota_Pedido',
        'Codigo_Importador',
        'Codigo_Exportador',
        'Remitir_Nota_Pedido',
        'Pais_Nota_Pedido',
        'Forma_Pago_Nota_Pedido',
        'Moneda_Nota_Pedido',
        'Fob_Nota_Pedido',
        'Flete_Nota_Pedido',
        'Seguro_Nota_Pedido',
        'Procesado_Nota_Pedido',
        'Transporte_Nota_Pedido',
        'Embarque_Nota_Pedido',
        'Destino_Nota_Pedido',
        'Costo_Flete_Nota_Pedido',
        'Total_Nota_Pedido',
        'Transferencia_Nota_Pedido',
        'Saldo_Nota_Pedido',
        'Numero_Nota_Pedido',
        'Valor_Compra_Nota_Pedido',
        'Saldo_Inicial_Nota_Pedido',
        'Saldo_Tmp_Nota_Pedido',
        'Codigo_Importacion',
        'Anio_Nota_Pedido',
        'Desactivado_Nota_Pedido'
    ];


    public $id;
    public $Codigo_Nota_Pedido;
    public $Fecha_Nota_Pedido;
    public $Codigo_Importador;
    public $Codigo_Exportador;
    public $Remitir_Nota_Pedido;
    public $Pais_Nota_Pedido;
    public $Forma_Pago_Nota_Pedido;
    public $Moneda_Nota_Pedido;
    public $Fob_Nota_Pedido;
    public $Flete_Nota_Pedido;
    public $Seguro_Nota_Pedido;
    public $Procesado_Nota_Pedido;
    public $Transporte_Nota_Pedido;
    public $Embarque_Nota_Pedido;
    public $Destino_Nota_Pedido;
    public $Costo_Flete_Nota_Pedido;
    public $Total_Nota_Pedido;
    public $Transferencia_Nota_Pedido;
    public $Saldo_Nota_Pedido;
    public $Numero_Nota_Pedido;
    public $Valor_Compra_Nota_Pedido;
    public $Saldo_Inicial_Nota_Pedido;
    public $Saldo_Tmp_Nota_Pedido;
    public $Codigo_Importacion;
    public $Anio_Nota_Pedido;
    public $Desactivado_Nota_Pedido;



    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->Codigo_Nota_Pedido = $args['Codigo_Nota_Pedido'] ?? null;
        $this->Fecha_Nota_Pedido = $args['Fecha_Nota_Pedido'] ?? null;
        $this->Codigo_Importador = $args['Codigo_Importador'] ?? null;
        $this->Codigo_Exportador = $args['Codigo_Exportador'] ?? null;
        $this->Remitir_Nota_Pedido = $args['Remitir_Nota_Pedido'] ?? null;
        $this->Pais_Nota_Pedido = $args['Pais_Nota_Pedido'] ?? null;
        $this->Forma_Pago_Nota_Pedido = $args['Forma_Pago_Nota_Pedido'] ?? null;
        $this->Moneda_Nota_Pedido = $args['Moneda_Nota_Pedido'] ?? null;
        $this->Fob_Nota_Pedido = $args['Fob_Nota_Pedido'] ?? 0.00;
        $this->Flete_Nota_Pedido = $args['Flete_Nota_Pedido'] ?? 0.00;
        $this->Seguro_Nota_Pedido = $args['Seguro_Nota_Pedido'] ?? 0.00;
        $this->Procesado_Nota_Pedido = $args['Procesado_Nota_Pedido'] ?? null;
        $this->Transporte_Nota_Pedido = $args['Transporte_Nota_Pedido'] ?? null;
        $this->Embarque_Nota_Pedido = $args['Embarque_Nota_Pedido'] ?? null;
        $this->Destino_Nota_Pedido = $args['Destino_Nota_Pedido'] ?? null;
        $this->Costo_Flete_Nota_Pedido = $args['Costo_Flete_Nota_Pedido'] ?? 0.00;
        $this->Total_Nota_Pedido = $args['Total_Nota_Pedido'] ?? 0.00;
        $this->Transferencia_Nota_Pedido = $args['Transferencia_Nota_Pedido'] ?? 0.00;
        $this->Saldo_Nota_Pedido = $args['Saldo_Nota_Pedido'] ?? 0.00;
        $this->Numero_Nota_Pedido = $args['Numero_Nota_Pedido'] ?? null;
        $this->Valor_Compra_Nota_Pedido = $args['Valor_Compra_Nota_Pedido'] ?? 0.00;
        $this->Saldo_Inicial_Nota_Pedido = $args['Saldo_Inicial_Nota_Pedido'] ?? 0.00;
        $this->Saldo_Tmp_Nota_Pedido = $args['Saldo_Tmp_Nota_Pedido'] ?? 0.00;
        $this->Codigo_Importacion = $args['Codigo_Importacion'] ?? null;
        $this->Anio_Nota_Pedido = $args['Anio_Nota_Pedido'] ?? null;
        $this->Desactivado_Nota_Pedido = $args['Desactivado_Nota_Pedido'] ?? 0;
    }

    

}

