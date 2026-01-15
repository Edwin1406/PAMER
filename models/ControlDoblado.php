<?php
namespace Model;

class ControlDoblado extends ActiveRecord {
    protected static $tabla = 'control_doblado';
    protected static $columnasDB = [
        'id',
        'fecha',
        'turno',
        'personal', // Assuming this is a comma-separated string of personal names
        'area',
        'horas_programadas',
        'cantidad_laminas',
        'cantidad_lamina_hora',
        'n_cambio',
        'consumo_goma',
        'desperdicio_kg',
        

    ];

    public $id;
    public $fecha;
    public $turno;
    public $personal; // Comma-separated string of personal names
    public $area;
    public $horas_programadas;
    public $cantidad_laminas;
    public $cantidad_lamina_hora;
    public $n_cambio;
    public $consumo_goma;
    public $desperdicio_kg;


    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->fecha = $data['fecha'] ?? null;
        $this->turno = $data['turno'] ?? null;
        $this->personal = $data['personal'] ?? null;
        $this->area = $data['area'] ?? 'Doblado'; // Default area
        $this->horas_programadas = $data['horas_programadas'] ?? null;
        $this->cantidad_laminas = $data['cantidad_laminas'] ?? null;
        $this->cantidad_lamina_hora = $data['cantidad_lamina_hora'] ?? null;
        $this->n_cambio = $data['n_cambio'] ?? null;
        $this->consumo_goma = $data['consumo_goma'] ?? null;
        $this->desperdicio_kg = $data['desperdicio_kg'] ?? null;
    }


     public function validar() {
        if(!$this->fecha) {
            self::$alertas['error'][] = 'La fecha es obligatoria';
        } 

        if(!$this->turno) {
            self::$alertas['error'][] = 'El turno es obligatorio';
        }

        if(!$this->area) {
            self::$alertas['error'][] = 'El área es obligatoria';
        }

        if(!$this->horas_programadas) {
            self::$alertas['error'][] = 'Las horas programadas son obligatorias';
        }

        // if(!$this->cantidad_laminas) {
        //     self::$alertas['error'][] = 'La cantidad de láminas es obligatoria';
        // }

        // if(!$this->cantidad_lamina_hora) {
        //     self::$alertas['error'][] = 'La cantidad de láminas por hora es obligatoria';
        // }

        // if(!$this->n_cambio) {
        //     self::$alertas['error'][] = 'El número de cambio es obligatorio';
        // }

        // if(!$this->desperdicio_kg) {
        //     self::$alertas['error'][] = 'El desperdicio en kg es obligatorio';
        // }

        // if(!$this->consumo_goma) {
        //     self::$alertas['error'][] = 'El consumo de goma es obligatorio';
        // }

        return self::$alertas;
    }



  
 public function convertirHorasADecimal($horas) {
    $horas = trim($horas); // eliminar espacios alrededor
    $partes = explode(':', $horas);
    
    if (count($partes) !== 2 || !is_numeric($partes[0]) || !is_numeric($partes[1])) {
        return 0; // Formato incorrecto
    }

    $horasDecimal = (int)$partes[0] + ((int)$partes[1] / 60);
    return $horasDecimal;
}








}