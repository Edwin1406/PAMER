<?php
namespace Classes;

use TCPDF;

class Pdf extends TCPDF 
{
    public function Header()
    {
        $this->SetFont('helvetica', 'B', 12); // Cambia Arial por helvetica
        $this->Cell(0, 10, 'Etiqueta', 0, 0, 'C');
        $this->Ln(20);
    }
    
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8); // Cambia Arial por helvetica
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
    
    
    public function generarPdf($datos)
    {
        // Agregar una nueva página
        $this->AddPage();
    
        // Centrar el contenedor principal en la página
        $pageWidth = $this->GetPageWidth();
        $pageHeight = $this->GetPageHeight();
    
        $etiquetaWidth = 100; // Ancho de la etiqueta
        $etiquetaHeight = 120; // Alto de la etiqueta
        $x = ($pageWidth - $etiquetaWidth) / 2;
        $y = ($pageHeight - $etiquetaHeight) / 2;
    
        // Dibujar contenedor principal con bordes redondeados y sombra
        $this->SetDrawColor(220, 220, 220); // Gris claro para el borde
        // fondo blanco
        $this->SetFillColor(255, 255, 255); // Fondo blanco
        $this->RoundedRect($x, $y, $etiquetaWidth, $etiquetaHeight, 5, '1111', 'DF');
    
        // Encabezado con degradado
        $this->SetFillColor(255, 140, 0); // Color degradado inicial
        $this->RoundedRect($x, $y, $etiquetaWidth, 20, 5, '1111', 'F'); // Encabezado
        $this->SetFont('helvetica', 'B', 14);
        $this->SetTextColor(255, 255, 255); // Blanco
        $this->SetXY($x, $y + 5);
        $this->Cell($etiquetaWidth, 10, 'MEGASTOCK', 0, 1, 'C');
    
        // Imagen del logo (centrado)
        $this->Image('src/img/logo2.png', $x + 13, $y + 2, 14, 14); // Tamaño y posición del logo
    
        // Datos principales con diseño moderno
        $this->SetFont('helvetica', '', 10);
        $this->SetTextColor(50, 50, 50); // Gris oscuro para texto
    
        // TIPO
        $this->SetXY($x + 10, $y + 25);
        $this->Cell(40, 6, 'TIPO:', 0, 0, 'L');
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(40, 6, $datos['tipo'], 0, 1, 'L');
    
        // ANCHO
        $this->SetFont('helvetica', '', 10);
        $this->SetXY($x + 10, $y + 35);
        $this->Cell(40, 6, 'ANCHO:', 0, 0, 'L');
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(40, 6, $datos['ancho'], 0, 1, 'L');
    
        // PESO
        $this->SetFont('helvetica', '', 10);
        $this->SetXY($x + 10, $y + 45);
        $this->Cell(40, 6, 'PESO:', 0, 0, 'L');
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(40, 6, $datos['peso'], 0, 1, 'L');
    
        // FECHA
        $this->SetFont('helvetica', '', 10);
        $this->SetXY($x + 10, $y + 55);
        $this->Cell(40, 6, 'FECHA:', 0, 0, 'L');
        $this->SetFont('helvetica', 'B', 10);
        $this->Cell(40, 6, $datos['created_at'], 0, 1, 'L');
    
        // Línea divisoria suave
        $this->SetDrawColor(200, 200, 200);
        $this->Line($x + 10, $y + 80, $x + $etiquetaWidth - 10, $y + 80);
    
        // Código de barras centrado
        $this->SetXY($x + 10, $y + 85);
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0), // Negro
            'bgcolor' => false, // Sin fondo
            'text' => true, // Sin texto debajo
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
        $this->write1DBarcode($datos['barcode'], 'C128', $x + 25, $y + 90, 50, 15, 0.4, $style, 'N');
    
        // Etiqueta estilizada con sombra
        $this->SetDrawColor(220, 220, 220); // Sombra exterior clara
        $this->RoundedRect($x + 1, $y + 1, $etiquetaWidth - 2, $etiquetaHeight - 2, 4, '1111');
    }
    
    
    

    public function descargarPdf($materias)
    {
        $this->generarPdf($materias);
        $this->Output('reporte.pdf', 'D');
    }

    public function verPdf($materias)
    {
        $this->generarPdf($materias);
        $this->Output('reporte.pdf', 'I');
    }

    public function guardarPdf($materias)
    {
        $this->generarPdf($materias);
        $this->Output('reporte.pdf', 'F');
    }

    public function enviarPdf($materias)
    {
        $this->generarPdf($materias);
        $this->Output('reporte.pdf', 'E');
    }

    public function imprimirPdf($materias)
    {
        $this->generarPdf($materias);
        $this->Output('reporte.pdf', 'I');
    }

    public function __construct()
    {
        parent::__construct();
    }


}