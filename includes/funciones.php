<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual_admin($path):bool{
    return str_contains($_SERVER['REQUEST_URI'] ?? '/', $path) ? true : false;

}
function pagina_actual($path): bool {
    return $_SERVER['REQUEST_URI'] === $path;
}

function isAuth() : bool {
    // si existe una sesion iniciada
    if(!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['nombre'])&& isset($_SESSION);
}
function isAdmin() : bool {
    if(!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['admin'])&& !empty($_SESSION['admin']);
}



function aos_animation():void{
    $efectos = ['fade-up', 'fade-down', 'fade-left', 'fade-right', 'fade-up-right', 'fade-up-left', 'fade-down-right', 'fade-down-left', 'flip-up', 'flip-down', 'flip-left', 'flip-right', 'slide-up', 'slide-down', 'slide-left', 'slide-right', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-in-left', 'zoom-in-right', 'zoom-out', 'zoom-out-up', 'zoom-out-down', 'zoom-out-left', 'zoom-out-right'];
    $efecto= array_rand($efectos, 1);
    echo $efectos[$efecto];
}
function dias(){
        
    setlocale(LC_TIME, 'es_ES.UTF-8'); // Configura la localización en español

    $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
    $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];

    $diaSemana = $dias[date('w')];
    $dia = date('d');
    $mes = $meses[date('n') - 1]; // date('n') da el número del mes (1-12), pero el índice del array empieza en 0
    $anio = date('Y');

    echo "$diaSemana $dia de $mes del $anio";


}



function repeatSession():void{
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_SESSION['nombre'])){
        echo $_SESSION['nombre'];
    }
}