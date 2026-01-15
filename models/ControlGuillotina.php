<?php
namespace Model;

class ControlGuillotina extends ActiveRecord {
    protected static $tabla = 'control_guillotina';
    protected static $columnasDB = [
        'id',
        'fecha',
        'turno',
        'area',
        'personal',
        'horas_programadas',
        'cantidad_resmas',
        'n_cambios_medidas',
        'n_cortes',
        'n_cortes_hora',
        'desperdicio_kg',
        'observaciones'

    ];


    public $id;
    public $fecha;
    public $turno;
    public $area;
    public $personal; 
    public $horas_programadas;
    public $cantidad_resmas;
    public $n_cambios_medidas;
    public $n_cortes;
    public $n_cortes_hora;
    public $desperdicio_kg;
    public $observaciones;



    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->fecha = $data['fecha'] ?? null;
        $this->turno = $data['turno'] ?? null;
        $this->area = $data['area'] ?? 'Guillotina'; // Default area
        $this->personal = $data['personal'] ?? null;
        $this->horas_programadas = $data['horas_programadas'] ?? null;
        $this->cantidad_resmas = $data['cantidad_resmas'] ?? null;
        $this->n_cambios_medidas = $data['n_cambios_medidas'] ?? null;
        $this->n_cortes = $data['n_cortes'] ?? null;
        $this->n_cortes_hora = $data['n_cortes_hora'] ?? null;
        $this->desperdicio_kg = $data['desperdicio_kg'] ?? null;
        $this->observaciones = $data['observaciones'] ?? null;
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

        if(!$this->personal) {
            self::$alertas['error'][] = 'El personal es obligatorio';
        }

        if(!$this->horas_programadas) {
            self::$alertas['error'][] = 'Las horas programadas son obligatorias';
        }

        // if(!$this->cantidad_resmas) {
        //     self::$alertas['error'][] = 'La cantidad de resmas es obligatoria';
        // }

        // if(!$this->n_cambios_medidas) {
        //     self::$alertas['error'][] = 'El número de cambios de medidas es obligatorio';
        // }

        // if(!$this->n_cortes) {
        //     self::$alertas['error'][] = 'El número de cortes es obligatorio';
        // }

        // if(!$this->n_cortes_hora) {
        //     self::$alertas['error'][] = 'El número de cortes por hora es obligatorio';
        // }

        // if(!$this->desperdicio_kg) {
        //     self::$alertas['error'][] = 'El desperdicio en kg es obligatorio';
        // }

        return self::$alertas;
    }


    public function convertirHorasADecimal($horas) {
        $partes = explode(':', $horas);
        if (count($partes) === 2) {
            $horasDecimal = (int)$partes[0] + ((int)$partes[1] / 60);
            return $horasDecimal;
        }
        return 0; // Si no es un formato válido, retornar 0
    }










}