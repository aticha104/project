<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . "/db.php";

ini_set('display_errors', 0);
error_reporting(0);

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['fnc'])) {
    echo json_encode(["status" => 0, "message" => "No function"]);
    exit;
}

if ($data['fnc'] === "find_department") {

    $sql = "SELECT POSITION_ID, POSITION_NAME FROM departments";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => 1,
        "data" => $rows
    ]);
    exit;
}

echo json_encode(["status" => 0, "message" => "Invalid function"]);
exit;

 