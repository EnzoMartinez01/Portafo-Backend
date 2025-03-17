<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require '../src/FormsController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
        exit;
    }

    $formController = new FormsController();
    $response = $formController->saveForms($data);

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
