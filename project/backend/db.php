<?php
$host = "localhost";
$dbname = "document_meeting";
$username = "root";
$password = "";
$charset = "utf8mb4";

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $e->getMessage()
    ]);
    exit;
}
