<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class CorreoTicket
{

    public $email;
    public $emailusuario;
    public $computadora_id;
    public $usuario_asignado;
    public $descripcion;
    public $fecha_creacion;
    public $estado;
    public $prioridad;
    public $categoria;


    public function __construct($email, $emailusuario, $computadora_id, $usuario_asignado, $descripcion, $fecha_creacion, $estado, $prioridad, $categoria)
    {
        $this->email = $email;
        $this->emailusuario = $emailusuario;
        $this->computadora_id = $computadora_id;
        $this->usuario_asignado = $usuario_asignado;
        $this->descripcion = $descripcion;
        $this->fecha_creacion = $fecha_creacion;
        $this->estado = $estado;
        $this->prioridad = $prioridad;
        $this->categoria = $categoria;
    }

    public function enviarConfirmacionTicket()
    {

        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        //  $mail->SMTPSecure = 'ssl';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;



        $mail->setFrom('sistemas@logmegaecuador.com', 'MEGASTOCK S.A.');
        $mail->addAddress($this->email, $this->usuario_asignado);
        $mail->addAddress($this->emailusuario, $this->usuario_asignado);
        $mail->Subject = 'Nuevo Ticket de Soporte - MEGASTOCK S.A.';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $contenido = '<html>';
        $contenido .= "<head><style>
             body {
                 font-family: Arial, sans-serif;
                 background-color: #f4f4f9;
                 color: #333;
                 padding: 20px;
             }
             .ticket-container {
                 background-color: #fff;
                 border-radius: 8px;
                 box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                 padding: 20px;
                 max-width: 600px;
                 margin: auto;
             }
             .ticket-header {
                 background-color:rgb(228, 203, 90);
                 color: #fff;
                 padding: 10px;
                 border-radius: 8px 8px 0 0;
                 text-align: center;
             }
             .ticket-details p {
                 margin: 1rem;
                 font-size: 14px;
             }
             .ticket-details strong {
                 color:rgb(218, 154, 101);
             }
             .footer {
                 text-align: center;
                 font-size: 12px;
                 color: #777;
                 margin-top: 20px;
             }
             .ticket-footer {
                 background-color: #f1f1f1;
                 padding: 15px;
                 border-radius: 0 0 8px 8px;
                 text-align: center;
             }
         </style></head>";
        $contenido .= "<body>";
        $contenido .= "<div class='ticket-container'>";
        $contenido .= "<div class='ticket-header'><h2>Nuevo Ticket de Soporte</h2></div>";
        $contenido .= "<div class='ticket-details'>";
        $contenido .= "<p> <strong>Hola " . $this->usuario_asignado . "</strong>, Has creado un ticket con los siguientes datos:</p>";
        $contenido .= "<p> <strong>Computadora ID:</strong> " . $this->computadora_id . "</p>";
        $contenido .= "<p> <strong>Descripción:</strong> " . $this->descripcion . "</p>";
        $contenido .= "<p> <strong>Fecha de Creación:</strong> " . $this->fecha_creacion . "</p>";
        $contenido .= "<p> <strong>Estado:</strong> " . $this->estado . "</p>";
        $contenido .= "<p> <strong>Prioridad:</strong> " . $this->prioridad . "</p>";
        $contenido .= "<p> <strong>Categoría:</strong> " . $this->categoria . "</p>";
        $contenido .= "<p> Llegaré a la brevedad posible para atender tu solicitud.</p>";
        $contenido .= "</div>";
        $contenido .= "<div class='ticket-footer'><p>En caso de que no hayas solicitado este ticket, por favor contacta al departamento de sistemas.</p></div>";
        $contenido .= "</div>";
        $contenido .= "<div class='footer'><p>&copy; 2025 MEGASTOCK S.A. - Todos los derechos reservados.</p></div>";
        $contenido .= "</body></html>";
        $mail->Body = $contenido;


        //Enviar el mail
        $mail->send();
    }
}
