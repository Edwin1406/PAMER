<?php
namespace Classes;

use TCPDF;
class InventarioPdf extends TCPDF 
{
    // public function Header()
    // {
    //     // Agregar logo a la izquierda
    //     $this->Image('src/img/logo2.png', 13, 5, 30, 30); // Tamaño y posición del logo
    //     $this->SetFont('helvetica', 'B', 12); 
    //     $this->Cell(0, 10, 'Inventario', 0, 0, 'C');
    //     $this->Ln(10);
    // }
    
    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8); 
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
    
    public function generarPdf($datos)
    {
        // Agregar una nueva página
        $this->AddPage('L'); // 'L' para landscape (horizontal)
    
        // Configuración de fuentes y colores
        $this->SetFont('helvetica', 'B', 14);
        $this->SetTextColor(0, 0, 0); 
    
        // Título de la página
        $this->SetXY(10, 10);
        $this->Cell(90, 20, 'MEGASTOCK S.A.', 0, 1, 'C');
        $this->SetFont('helvetica', 'B', 18);
        $this->Cell(290, 10, 'INVENTARIO SISTEMAS', 0, 1, 'C');

        // Fecha A la derecha
        $this->SetXY(10, 40);
        $this->SetFont('helvetica', 'I', 12);
        $this->Cell(450, 10, 'Fecha: ' . date('d/m/Y'), 0, 1, 'C');
            
        // Espaciado
        $this->Ln(5);
    
        // Cabecera de la tabla mejorada
        $this->SetFillColor(255, 140, 0); // Naranja
        $this->SetTextColor(255, 255, 255); // Blanco
        $this->SetFont('helvetica', 'B', 14); // Aumentar tamaño de fuente
    
        // Centrar la tabla
        $totalAnchoTabla = 93.1 + 40 + 30 + 20 + 94.4; // Ancho total de la tabla
        $margenIzquierdo = ($this->getPageWidth() - $totalAnchoTabla) / 2; // Calcular el margen izquierdo para centrar
        $this->SetX($margenIzquierdo);
        
        // Encabezados de la tabla
        $this->Cell(100, 10, 'Producto', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Área', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Costo Unitario', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Cantidad', 1, 0, 'C', true);
        $this->Cell(30.5, 10, 'Total', 1, 1, 'C', true);
    
        // Datos de los productos
        $this->SetFont('helvetica', '', 12);
        $this->SetTextColor(50, 50, 50); 
    
        $total = 0;
    
        foreach ($datos['inventarioProductos'] as $producto) {
            if ($producto->stock_actual > 0) {
                $this->Cell(100, 10, $producto->nombre_producto, 1, 0, 'L');
                $this->Cell(40, 10, 'Producción', 1, 0, 'L');
                $this->Cell(50, 10, '$' . number_format($producto->costo_unitario, 2), 1, 0, 'C');
                $this->Cell(30, 10, number_format($producto->stock_actual, 2), 1, 0, 'C');
                
                $totalProducto = $producto->costo_unitario * $producto->stock_actual;
                $this->Cell(30, 10, '$' . number_format($totalProducto, 2), 1, 1, 'C');
                
                $total += $totalProducto;
            }
        }
        
        // Total final con fondo y bordes más llamativos
        $this->SetFont('helvetica', 'B', 14);
        $this->SetFillColor(255, 140, 0); // Naranja
        $this->SetTextColor(255, 255, 255); 
        $this->Cell(200, 10, 'TOTAL:', 1, 0, 'R', true);
        $this->Cell(50, 10, '$' . number_format($total, 2), 1, 1, 'C', true);
    
        // Nota al pie con espacio extra
        $this->SetFont('helvetica', 'I', 8);
        $this->Ln(10);
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