<?php

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

class Mailer {
    public static function sendEmail($names, $email, $message) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = getenv('MAIL_HOST') ?: $_ENV['MAIL_HOST'] ?? null;
            $mail->SMTPAuth = true;
            $mail->Username = getenv('MAIL_USERNAME') ?: $_ENV['MAIL_USERNAME'] ?? null;
            $mail->Password = getenv('MAIL_PASSWORD') ?: $_ENV['MAIL_PASSWORD'] ?? null;
            $mail->SMTPSecure = getenv('MAIL_ENCRYPTION') ?: $_ENV['MAIL_ENCRYPTION'] ?? 'tls';
            $mail->Port = getenv('MAIL_PORT') ?: $_ENV['MAIL_PORT'] ?? 587;

            $mail->setFrom($mail->Username, getenv('MAIL_FROM_NAME') ?: $_ENV['MAIL_FROM_NAME'] ?? 'No-Reply');
            $mail->addAddress(getenv('MAIL_FROM_ADDRESS') ?: $_ENV['MAIL_FROM_ADDRESS'] ?? 'admin@example.com', 'Administrador');

            $mail->isHTML(true);
            $mail->Subject = 'Nuevo Mensaje de Contacto';
            $mail->Body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; color: #333; }
                        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; }
                        h2 { color: #007bff; }
                        .info { font-size: 16px; margin-bottom: 10px; }
                        .message { padding: 10px; background: #eef; border-left: 4px solid #007bff; }
                        .footer { margin-top: 20px; font-size: 14px; color: #666; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h2>📩 Nuevo Mensaje de Contacto</h2>
                        <p class='info'><strong>👤 Nombre:</strong> $names</p>
                        <p class='info'><strong>📧 Email:</strong> $email</p>
                        <div class='message'>
                            <strong>📝 Mensaje:</strong>
                            <p>$message</p>
                        </div>
                        <p class='footer'>Este mensaje fue enviado desde el formulario de contacto de Enzo Martinez Portafolio.</p>
                    </div>
                </body>
                </html>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al enviar email: ' . $mail->ErrorInfo];
        }
    }
}
?>
