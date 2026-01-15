<?php
if (isset($_GET['file']) && isset($_GET['nombre'])) {
    // 🔹 Quitar solo espacios al inicio y final
    $archivoNombre = trim(basename($_GET['file'])); 
    $nombreDescarga = trim($_GET['nombre']) . ".pdf";
    // CIDAR MUCHO LAS RTAS 

    $archivoNombre = preg_replace('/\s+/', '_', $archivoNombre);
    $nombreDescarga = preg_replace('/\s+/', '_', $nombreDescarga);
    
    // Ruta dentro de public/src/visor/
    $archivo = __DIR__ . "/src/visor/" . $archivoNombre;

    if (file_exists($archivo)) {
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=\"" . $nombreDescarga . "\"");
        header("Content-Length: " . filesize($archivo));
        readfile($archivo);
        exit;
    } else {
        echo "Archivo no encontrado.<br>";
        echo "Ruta buscada: " . $archivo;
    }
} else {
    echo "Parámetros inválidos.";
}
?>







