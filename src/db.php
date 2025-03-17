<?php

use Dotenv\Dotenv;

require '../vendor/autoload.php';


class Database {
    private $client;
    private $db;

    public function __construct() {
       try {
            $mongoUri = getenv('MONGODB_URI') ?: $_ENV['MONGODB_URI'] ?? null;
            $mongoDb = getenv('MONGODB_DATABASE') ?: $_ENV['MONGODB_DATABASE'] ?? null;

            if (!$mongoUri || !$mongoDb) {
                throw new Exception("Variables de entorno no configuradas correctamente.");
            }

            $this->client = new MongoDB\Client($mongoUri);
            $this->db = $this->client->selectDatabase($mongoDb);
        } catch (Exception $e) {
            die("Error de conexión a MongoDB: " . $e->getMessage());
        }
    }

    public function getCollection($collectionName) {
        return $this->db->$collectionName;
    }
}
?>
