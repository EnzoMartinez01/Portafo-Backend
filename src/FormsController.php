<?php
require_once "db.php";
require_once "Mailer.php";

class FormsController {
    private $collection;

    public function __construct() {
        $database = new Database();
        $this->collection = $database->getCollection("contact");
    }

    public function saveForms($data) {
        if (!isset($data['names']) || !isset($data['email']) || !isset($data['message'])) {
            return ['success' => false, 'message' => 'Falta campo obligatorio'];
        }
    
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Correo inválido'];
        }
    
        $safeData = [
            'names' => htmlspecialchars($data['names'], ENT_QUOTES, 'UTF-8'),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'message' => htmlspecialchars($data['message'], ENT_QUOTES, 'UTF-8')
        ];
    
        try {
            $this->collection->insertOne($safeData);
            Mailer::sendEmail($safeData['names'], $safeData['email'], $safeData['message']);
    
            return ['success' => true, 'message' => 'Formulario enviado correctamente'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error al guardar en la base de datos'];
        }
    }
}