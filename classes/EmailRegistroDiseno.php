<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailRegistroDiseno
{
  public $emaildefault;
  public $nombre;
  public $token;
  public $estado;
  public $tipo_producto;
  public $tipo_componente;
  public $alto;
  public $largo;
  public $ancho;
  public $dobles;
  public $flauta;
  public $material;
  public $ect;
  public $descripcion;
  public $observaciones;


  public function __construct($emaildefault, $nombre, $token, $estado, $tipo_producto, $tipo_componente, $alto, $largo, $ancho, $dobles, $flauta, $material, $ect, $descripcion, $observaciones)
  {
    $this->emaildefault = $emaildefault;
    $this->nombre       = $nombre;
    $this->token        = $token;
    $this->estado       = $estado;
    $this->tipo_producto = $tipo_producto;
    $this->tipo_componente = $tipo_componente;
    $this->alto        = $alto;
    $this->largo       = $largo;
    $this->ancho      = $ancho;
    $this->dobles     = $dobles;
    $this->flauta     = $flauta;
    $this->material   = $material;
    $this->ect        = $ect;
    $this->descripcion  = $descripcion;
    $this->observaciones = $observaciones;
  }

  public function enviarConfirmacion2()
  {
    // Sanitiza
    $nombre = htmlspecialchars($this->nombre ?? '', ENT_QUOTES, 'UTF-8');
    $token  = htmlspecialchars($this->token ?? '', ENT_QUOTES, 'UTF-8');
    $estado = htmlspecialchars($this->estado ?? '', ENT_QUOTES, 'UTF-8');
    $tipo_producto = htmlspecialchars($this->tipo_producto ?? '', ENT_QUOTES, 'UTF-8');
    $tipo_componente = htmlspecialchars($this->tipo_componente ?? '', ENT_QUOTES, 'UTF-8');
    $alto   = htmlspecialchars($this->alto ?? '', ENT_QUOTES, 'UTF-8');
    $largo  = htmlspecialchars($this->largo ?? '', ENT_QUOTES, 'UTF-8');
    $ancho  = htmlspecialchars($this->ancho ?? '', ENT_QUOTES, 'UTF-8');
    $dobles = htmlspecialchars($this->dobles ?? '', ENT_QUOTES, 'UTF-8');
    $flauta = htmlspecialchars($this->flauta ?? '', ENT_QUOTES, 'UTF-8');
    $material = htmlspecialchars($this->material ?? '', ENT_QUOTES, 'UTF-8');
    $ect    = htmlspecialchars($this->ect ?? '', ENT_QUOTES, 'UTF-8');
    $descripcion = htmlspecialchars($this->descripcion ?? '', ENT_QUOTES, 'UTF-8');
    $observaciones = htmlspecialchars($this->observaciones ?? '', ENT_QUOTES, 'UTF-8');

    // Colores según estado
    $estadoKey = strtolower(trim($this->estado ?? ''));
    $estatusColors = [
      'pendiente' => ['bg' => '#dc2626', 'text' => '#ffffff'], // rojo
      'aprobado'  => ['bg' => '#0ea5e9', 'text' => '#ffffff'], // celeste
      'rechazado' => ['bg' => '#6b7280', 'text' => '#ffffff'], // gris
    ];
    $colorEstadoBG   = $estatusColors[$estadoKey]['bg']   ?? '#0ea5e9';
    $colorEstadoTEXT = $estatusColors[$estadoKey]['text'] ?? '#ffffff';

    date_default_timezone_set('America/Guayaquil');
    $fecha = date('Y-m-d H:i:s');
    $anio  = date('Y');

    // Construimos los detalles dinámicamente
    $detalles = '';
    if (!empty($alto) && $alto != "0") {
      $detalles .= "<strong>Alto:</strong> $alto cm<br>";
    }
    if (!empty($largo) && $largo != "0") {
      $detalles .= "<strong>Largo:</strong> $largo cm<br>";
    }
    if (!empty($ancho) && $ancho != "0") {
      $detalles .= "<strong>Ancho:</strong> $ancho cm<br>";
    }
    if (!empty($dobles) && strtolower($dobles) != "0") {
      $detalles .= "<strong>Dobles:</strong> $dobles<br>";
    }
    if (!empty($flauta) && strtolower($flauta) != "0") {
      $detalles .= "<strong>Flauta:</strong> $flauta<br>";
    }
    if (!empty($material) && strtolower($material) != "0") {
      $detalles .= "<strong>Material:</strong> $material<br>";
    }
    if (!empty($ect) && $ect != "0") {
      $detalles .= "<strong>ECT:</strong> $ect lbs<br>";
    }


    // Bloque de detalles (solo si hay datos)
    $bloqueDetalles = '';
    if (!empty($detalles)) {
      $bloqueDetalles = '
        <p style="margin:0 0 14px 0;font-size:14px;line-height:1.6;">
          <strong>Detalles del diseño:</strong><br>
          ' . $detalles . '
        </p>';
    }

    $contenido = '
<!doctype html>
<html lang="es">
  <body style="margin:0;padding:0;background:#f5f7fb;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7fb;padding:18px 10px;">
      <tr>
        <td align="center">
          <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;background:#ffffff;border-radius:12px;box-shadow:0 6px 20px rgba(0,0,0,0.08);overflow:hidden;font-family:Arial,Helvetica,sans-serif;color:#2d3748;">
            <!-- Header -->
            <tr>
              <td style="background:#111827;padding:14px 18px;text-align:center;">
                <div style="font-size:16px;font-weight:700;color:#ffffff;letter-spacing:.3px;">MEGASTOCK S.A.</div>
                <div style="font-size:11px;color:#cbd5e1;margin-top:2px;">Registro de Diseño</div>
              </td>
            </tr>

            <!-- Body -->
            <tr>
              <td style="padding:20px;">
                <p style="margin:0 0 8px 0;font-size:16px;"><strong>De: ' . $nombre . ',</strong></p>
                <p style="margin:0 0 14px 0;font-size:14px;line-height:1.6;">
                  Ha realizado un registro de un diseño y su estado actual es:
                </p>

                <!-- Badge de estado -->
                <span style="
                  display:inline-block;
                  background:' . $colorEstadoBG . ';
                  color:' . $colorEstadoTEXT . ';
                  font-weight:700;
                  border-radius:999px;
                  padding:6px 12px;
                  font-size:12px;
                  letter-spacing:.3px;
                  text-transform:uppercase;
                  line-height:1;
                  vertical-align:middle;
                ">' . $estado . '</span>

                <br>

                <p style="margin:0 0 14px 0;font-size:14px;line-height:1.6;">
                  <strong>Descripción:</strong> ' . $descripcion . '
                </p>

            
                <p style="margin:0 0 14px 0;font-size:14px;line-height:1.6;">
                  <strong>Tipo de producto:</strong> ' . $tipo_producto . '
                </p>

                <p style="margin:0 0 14px 0;font-size:14px;line-height:1.6;">
                  <strong>Tipo de componente:</strong> ' . $tipo_componente . '
                </p>

                ' . $bloqueDetalles . '

                      <p style="margin:0 0 14px 0;font-size:14px;line-height:1.6;">
                  <strong>Observaciones:</strong> ' . $observaciones . '
                </p>
                <!-- Código -->
                <p style="margin:16px 0 6px 0;font-size:14px;">Tu código de diseño es:</p>
                <span style="
                  display:inline-block;
                  background:#0284c7;
                  color:#ffffff;
                  font-weight:700;
                  border-radius:8px;
                  padding:8px 12px;
                  font-size:14px;
                  letter-spacing:.5px;
                  line-height:1;
                  vertical-align:middle;
                  text-decoration:none;
                ">' . $token . '</span>

                <!-- Fecha -->
                <p style="margin:14px 0 0 0;font-size:14px;">
                  Fecha de creación: <strong>' . $fecha . '</strong>
                </p>

                <!-- Nota -->
                <div style="margin-top:18px;padding:12px 12px;border:1px solid #e5e7eb;border-radius:10px;background:#fafafa;font-size:12px;color:#6b7280;line-height:1.5;">
                  Si no realizaste este registro, puedes ignorar este mensaje.
                </div>
              </td>
            </tr>

            <!-- Footer -->
            <tr>
              <td style="padding:12px 18px;border-top:1px solid #f1f5f9;text-align:center;background:#ffffff;">
                <div style="font-size:12px;color:#94a3b8;">
                  © ' . $anio . ' MEGASTOCK S.A. — Desarrollado por
                  <span style="color:#94a3b8;text-decoration:none;">sistemas@megaecuador.com</span>
                </div>
              </td>
            </tr>
          </table>
          <div style="height:18px;line-height:18px;">&nbsp;</div>
        </td>
      </tr>
    </table>
  </body>
</html>';

    $alt = "Confirmación de Registro de Diseño\n"
      . "De: $nombre,\n"
      . "Estado: $estado\n"
      . "Código de diseño: $token\n"
      . "Fecha de creación: $fecha\n\n"
      . "Si no realizaste este registro, ignora este mensaje.\n"
      . "© $anio MEGASTOCK S.A.";

    // Envío con PHPMailer
    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->Host       = $_ENV["EMAIL_HOST"];
      $mail->SMTPAuth   = true;
      $mail->Port       = (int) $_ENV["EMAIL_PORT"];
      $mail->Username   = $_ENV["EMAIL_USER"];
      $mail->Password   = $_ENV["EMAIL_PASS"];
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->CharSet    = 'UTF-8';
      $mail->SMTPKeepAlive = true;

      $mail->setFrom('sistemas@logmegaecuador.com', 'DISEÑO MEGASTOCK S.A.');
      $mail->addBCC('artes@megaecuador.com');
      $mail->addAddress($this->emaildefault, $nombre);
      $mail->addReplyTo('sistemas@logmegaecuador.com', 'Soporte MEGASTOCK');
      $mail->Subject = 'Registro de Diseño';

      $mail->isHTML(true);
      $mail->Body    = $contenido;
      $mail->AltBody = $alt;

      $mail->send();
      return true;
    } catch (Exception $e) {
      return false;
    }
  }
}
