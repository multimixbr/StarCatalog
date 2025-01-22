<?php
require_once '../config/database.php';

class LogModel {

    private $db;

    public function __construct() {
        $this->db = dbConnect();
    }

    public function saveLog($requestType, $endpoint, $status, $response) {
        $sql = "INSERT INTO logs (request_type, endpoint, status, response, created_at) VALUES ('{$requestType}', '{$endpoint}', '{$status}', '{$response}', NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }

    public function saveError($endpoint, $error) {
        $sql = "INSERT INTO logs (request_type, endpoint, status, response, created_at) VALUES ('ERROR', '{$endpoint}', 500, '{$error}', NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }
}
