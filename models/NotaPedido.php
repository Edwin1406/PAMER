<?php 
namespace Model;

class NotaPedido extends ActiveRecord {

    protected static $tabla = 'NOTA_PEDIDO';
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
        $this->Fecha_Nota_Pedido = $args['Fecha_Nota_Pedido'] ?? '';
        $this->Codigo_Importador = $args['Codigo_Importador'] ?? '';
        $this->Codigo_Exportador = $args['Codigo_Exportador'] ?? '';
        $this->Remitir_Nota_Pedido = $args['Remitir_Nota_Pedido'] ?? '';
        $this->Pais_Nota_Pedido = $args['Pais_Nota_Pedido'] ?? '';
        $this->Forma_Pago_Nota_Pedido = $args['Forma_Pago_Nota_Pedido'] ?? '';
        $this->Moneda_Nota_Pedido = $args['Moneda_Nota_Pedido'] ?? '';
        $this->Fob_Nota_Pedido = $args['Fob_Nota_Pedido'] ?? '';
        $this->Flete_Nota_Pedido = $args['Flete_Nota_Pedido'] ?? '';
        $this->Seguro_Nota_Pedido = $args['Seguro_Nota_Pedido'] ?? '';
        $this->Procesado_Nota_Pedido = $args['Procesado_Nota_Pedido'] ?? '';
        $this->Transporte_Nota_Pedido = $args['Transporte_Nota_Pedido'] ?? '';
        $this->Embarque_Nota_Pedido = $args['Embarque_Nota_Pedido'] ?? '';
        $this->Destino_Nota_Pedido = $args['Destino_Nota_Pedido'] ?? '';
        $this->Costo_Flete_Nota_Pedido = $args['Costo_Flete_Nota_Pedido'] ?? '';
        $this->Total_Nota_Pedido = $args['Total_Nota_Pedido'] ?? '';
        $this->Transferencia_Nota_Pedido = $args['Transferencia_Nota_Pedido'] ?? '';
        $this->Saldo_Nota_Pedido = $args['Saldo_Nota_Pedido'] ?? '';
        $this->Numero_Nota_Pedido = $args['Numero_Nota_Pedido'] ?? '';
        $this->Valor_Compra_Nota_Pedido = $args['Valor_Compra_Nota_Pedido'] ?? '';
        $this->Saldo_Inicial_Nota_Pedido = $args['Saldo_Inicial_Nota_Pedido'] ?? '';
        $this->Saldo_Tmp_Nota_Pedido = $args['Saldo_Tmp_Nota_Pedido'] ?? '';
        $this->Codigo_Importacion = $args['Codigo_Importacion'] ?? '';
        $this->Anio_Nota_Pedido = $args['Anio_Nota_Pedido'] ?? '';
        $this->Desactivado_Nota_Pedido = $args['Desactivado_Nota_Pedido'] ?? '';
    }

    public function validar() {
        if(!$this->Codigo_Nota_Pedido) {
            self::$alertas['error'][] = 'El Campo Codigo Nota Pedido es Obligatorio';
        }

        

        // Aquí puedes agregar validaciones adicionales para otros campos si es necesario
        
        return self::$alertas;
    }
}
