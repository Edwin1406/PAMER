<?php

namespace Model;

class Pruebas extends ActiveRecord {
    protected static $tabla = 'pruebas';
    protected static $columnasDB = ['id', 'nombre', 'descripcion', 'fecha', 'resultado'];

    public ?int $id;
    public string $nombre;
    public string $descripcion;
    public string $fecha;
    public string $resultado;




}


