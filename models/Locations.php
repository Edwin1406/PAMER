<?php

namespace Model;

use DateTime;

class Locations extends ActiveRecord {    
    protected static $tabla = 'vehicle_locations';
    protected static $columnasDB = ['id','vehicle_code','vehicle_name','lat','lng','accuracy','heading','speed','measured_at','is_lastest','created_at','updated_at'];

    public ?int $id;
    public ?string $vehicle_code;
    public ?string $vehicle_name;
    public ?float $lat;
    public ?float $lng;
    public ?float $accuracy;
    public ?float $heading;
    public ?float $speed;
    public ?string $measured_at;
    public ?bool $is_lastest;
    public ?string $created_at;
    public ?string $updated_at;

    public function __construct(array $args = []) {
        date_default_timezone_set('America/Guayaquil');
        $fecha = date('Y-m-d H:i:s');

        $this->id = $args['id'] ?? null;
        $this->vehicle_code = $args['vehicle_code'] ?? '';
        $this->vehicle_name = $args['vehicle_name'] ?? '';
        $this->lat = $args['lat'] ?? null;
        $this->lng = $args['lng'] ?? null;
        $this->accuracy = $args['accuracy'] ?? null;
        $this->heading = $args['heading'] ?? null;
        $this->speed = $args['speed'] ?? null;
        $this->measured_at = $args['measured_at'] ?? null;
        $this->is_lastest = $args['is_lastest'] ?? null;
        $this->created_at = $args['created_at'] ?? $fecha;
        $this->updated_at = $args['updated_at'] ?? $fecha;

    }






/** NUEVO: inserta usando prepared statements para permitir NULL sin warnings */
    public function guardarPrepared(): bool
    {
        $db = self::$db;

        $sql = "INSERT INTO " . static::$tabla . " 
            (vehicle_code, vehicle_name, lat, lng, accuracy, heading, speed, measured_at, is_lastest, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $db->prepare($sql);
        if (!$stmt) {
            // opcional: loguea $db->error
            return false;
        }

        // Normaliza vacíos a NULL cuando aplique
        $vehicle_code = $this->vehicle_code;                       // requerido
        $vehicle_name = ($this->vehicle_name === '' ? null : $this->vehicle_name);
        $lat          = $this->lat;
        $lng          = $this->lng;
        $accuracy     = $this->accuracy; // puede ser null
        $heading      = $this->heading;  // puede ser null
        $speed        = $this->speed;    // puede ser null
        $measured_at  = $this->measured_at;
        $is_lastest   = (int) $this->is_lastest;
        $created_at   = $this->created_at;
        $updated_at   = $this->updated_at;

        // Tipos: s=string, d=double, i=int
        //            vc     vn     lat  lng  acc  hea  spd  meas  is_last  created  updated
        if (!$stmt->bind_param('ssdddddsiss',
            $vehicle_code, $vehicle_name, $lat, $lng, $accuracy, $heading, $speed, $measured_at, $is_lastest, $created_at, $updated_at
        )) {
            $stmt->close();
            return false;
        }

        $ok = $stmt->execute();
        if ($ok) {
            $this->id = $db->insert_id;
        }
        $stmt->close();
        return $ok;
    }

    /** Consulta para últimas posiciones activas */
    public static function ultimas(int $segundos = 60): array
    {
        $segundos = (int) max(5, $segundos);
        $tabla = static::$tabla;

        $query = "
            SELECT vehicle_code, vehicle_name, lat, lng, accuracy, heading, speed, measured_at
            FROM {$tabla}
            WHERE is_lastest = 1
              AND measured_at >= (NOW() - INTERVAL {$segundos} SECOND)
        ";

        return self::consultarSQL($query);
    }










}


