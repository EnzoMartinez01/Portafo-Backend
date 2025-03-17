<?php

use Dotenv\Dotenv;

require '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Database {
    private $client;
    private $db;

    public function __construct() {
        try {
            $this->client = new MongoDB\Client($_ENV['MONGODB_URI']);
            $this->db = $this->client->selectDatabase($_ENV['MONGODB_DATABASE']);
        } catch (Exception $e) {
            die("Error de conexión a MongoDB: " . $e->getMessage());
        }
    }

    public function getCollection($collectionName) {
        return $this->db->$collectionName;
    }
}
?>