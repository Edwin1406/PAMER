<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailDiseno
{

  public $email;     // destinatario
  public $nombre;
  public $codigo;
  public $tipo_producto;
  public $tipo_componente;
  public $alto;
  public $largo;
  public $ancho;
  public $dobles;

  public $descripcion;
  public $fecha_creacion;
  public $fecha_entrega;
  public $estado;
  public $posicion;

  public function __construct($email, $nombre, $codigo, $tipo_producto, $tipo_componente, $alto, $largo, $ancho, $dobles, $descripcion, $fecha_creacion, $fecha_entrega, $estado, $posicion)
  {
    $this->email = $email;
    $this->nombre = $nombre;
    $this->codigo = $codigo;
    $this->tipo_producto = $tipo_producto;
    $this->tipo_componente = $tipo_componente;
    $this->alto = $alto;
    $this->largo = $largo;
    $this->ancho = $ancho;
    $this->dobles = $dobles;
    $this->descripcion = $descripcion;
    $this->fecha_creacion = $fecha_creacion;
    $this->fecha_entrega = $fecha_entrega;
    $this->estado = $estado;
    $this->posicion = $posicion;
  }

  public function enviarConfirmacion()
  {
    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->Host       = $_ENV['EMAIL_HOST'];
      $mail->SMTPAuth   = true;
      $mail->Username   = $_ENV['EMAIL_USER'];
      $mail->Password   = $_ENV['EMAIL_PASS'];

      if ((int)$_ENV['EMAIL_PORT'] === 587) {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      } else {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
      }
      $mail->Port = (int)$_ENV['EMAIL_PORT'];
      $mail->SMTPKeepAlive = true;

      $mail->setFrom($_ENV['EMAIL_FROM'] ?? $_ENV['EMAIL_USER'], 'DISEÑO MEGASTOCK S.A.');
      $mail->addAddress($this->email, $this->nombre);
      $mail->addCC('artes@megaecuador.com');

      $mail->Subject = 'Turno editado #' . $this->codigo;
      $mail->isHTML(true);
      $mail->CharSet = 'UTF-8';

      // Helpers
      $e = fn($s) => htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
      $field = function ($label, $value) use ($e) {
        if ($value !== null && $value !== '' && $value !== '0') {
          return '
                    <div style="padding:10px 0;">
                      <div style="font-size:12px;color:#6b7280;text-transform:uppercase;
                                  letter-spacing:.6px;margin-bottom:4px;">' . $e($label) . '</div>
                      <div style="font-size:15px;color:#111827;">' . $e($value) . '</div>
                    </div>';
        }
        return '';
      };

      // Estado y colores
      $estadoRaw = strtolower(trim((string)$this->estado));
      $badgeText = 'Entregado';
      $badgeBg   = '#2e7d32'; // verde

      if ($estadoRaw === 'pendiente') {
        $badgeText = 'Pendiente';
        $badgeBg   = '#e53935'; // rojo
      } elseif ($estadoRaw === 'en proceso' || $estadoRaw === 'proceso') {
        $badgeText = 'En proceso';
        $badgeBg   = '#03a9f4'; // celeste
      }

      $host = rtrim($_ENV['HOST'] ?? '', '/');
      $url  = $host . '/admin/turnoDiseno/ver?turno_id=' . rawurlencode((string)$this->codigo);

      // HTML
      $contenido = '
<!DOCTYPE html>
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Turno editado</title>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:Arial, Helvetica, sans-serif;">
  <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#f5f7fb;padding:24px 12px;">
    <tr>
      <td align="center">
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width:640px;">
          <tr>
            <td style="background:#111827;color:#ffffff;padding:18px 24px;border-radius:12px 12px 0 0;text-align:left;">
              <div style="font-size:16px;letter-spacing:.5px;opacity:.9;">MEGASTOCK S.A.</div>
              <div style="font-size:20px;font-weight:bold;margin-top:2px;">Turno de diseño editado</div>
            </td>
          </tr>

          <tr>
            <td style="background:#ffffff;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 12px 12px;padding:0 24px 24px;">
              
              <!-- Encabezado con saludo + badge -->
              <div style="padding:20px 0 10px 0;border-bottom:1px solid #f0f2f5;display:flex;align-items:center;justify-content:space-between;gap:12px;">
                <div style="font-size:16px;color:#111827;line-height:1.4;">
                  <strong>Hola, ' . $e($this->nombre) . '</strong><br/>
                  Se editó el turno <strong>#' . $e($this->codigo) . '</strong>.
                </div>
                <span style="display:inline-block;font-size:16px;font-weight:bold;
                             color:#ffffff;background:' . $badgeBg . ';
                             padding:8px 14px;border-radius:999px;white-space:nowrap;">
                  ' . $e($badgeText) . '
                </span>
              </div>

              <!-- Cuerpo -->
              <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin-top:14px;">
                <tr>
                  <td style="padding:10px 0;">
                    <div style="font-size:12px;color:#6b7280;text-transform:uppercase;letter-spacing:.6px;margin-bottom:4px;">Descripción</div>
                    <div style="font-size:15px;color:#111827;line-height:1.5;background:#f9fafb;border:1px solid #eef2f7;border-radius:8px;padding:12px;">
                      ' . $e($this->descripcion) . '
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    ' . $field("Tipo de producto", $this->tipo_producto) . '
                    ' . $field("Tipo de componente", $this->tipo_componente) . '
                    ' . $field("Dimensiones", ($this->alto && $this->largo && $this->ancho) ? "{$this->alto} x {$this->largo} x {$this->ancho}" : "") . '
                    ' . $field("Doblado", $this->dobles) . '
                  </td>
                </tr>

                <tr>
                  <td style="padding:8px 0;">
                    <div style="display:flex;flex-wrap:wrap;gap:12px;">
                      ' . $field("Fecha de creación", $this->fecha_creacion) . '
                      ' . $field("Fecha de entrega", $this->fecha_entrega) . '
                      ' . $field("Orden de atención:", $this->posicion) . '
                    </div>
                  </td>
                </tr>
              </table>

              <div style="text-align:center;margin:18px 0;">
                <span style="font-size:24px;font-weight:bold;color:#111827;">MEGASTOCK S.A.</span>
              </div>

              <div style="font-size:12px;color:#6b7280;text-align:center;margin-top:18px;line-height:1.5;">
                Si no solicitaste este cambio o ves algo incorrecto, responde a este correo.
                <br/>
                CORREO: desarrollodeproductosms@gmail.com
                <br/>
                Desarrollado por Sistemas@megaecuador.com
              </div>

            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>
</html>';

      $mail->Body    = $contenido;
      $mail->AltBody = 'Se editó el turno #' . $this->codigo . ' (Estado: ' . $badgeText . '). Ver: ' . $url;

      $mail->send();
      return true;
    } catch (Exception $e) {
      error_log('PHPMailer error: ' . $mail->ErrorInfo);
      throw $e;
    }
  }
}
