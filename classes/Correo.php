<?php

namespace Classes;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;



class Correo {

    public function enviarConAdjunto($destinatario,$destinatario2, $asunto, $mensaje, $pdfContenido, $nombreArchivo = 'documento.pdf') {
        try {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT']; // 587
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;


            $mail->setFrom('sistemas@logmegaecuador.com', 'MEGASTOCK S.A.');
            $mail->addAddress($destinatario);
            $mail->addAddress($destinatario2);
            $mail->Subject = $asunto;

            // Configurar el mensaje
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Body = $mensaje;
            

            // Adjuntar el PDF generado en memoria
            $mail->addStringAttachment($pdfContenido, $nombreArchivo, 'base64', 'application/pdf');
            


         
            
            // Enviar el correo
            if (!$mail->send()) {
                throw new Exception('Error al enviar el correo: ' . $mail->ErrorInfo);
            }
            return true;
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}


