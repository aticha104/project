<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . "/db.php";

$data = json_decode(file_get_contents("php://input"), true);
$meeting_id = isset($data['meeting_id']) ? $data['meeting_id'] : null;

if (!$meeting_id) {
    echo json_encode(["success" => false, "message" => "Meeting ID is required"]);
    exit;
}

try {
    $pdo->beginTransaction();

    // Delete from related tables first (if they don't have ON DELETE CASCADE)
    // To be safe, we'll try to delete from common related tables if they exist
    
    // Check if agendas table exists (assuming name based on save_agendas.php)
    $stmt = $pdo->prepare("DELETE FROM agendas WHERE meeting_id = ?");
    $stmt->execute([$meeting_id]);

    // Check if absentees table exists
    $stmt = $pdo->prepare("DELETE FROM absentees WHERE meeting_id = ?");
    $stmt->execute([$meeting_id]);

    // Delete the meeting itself
    $stmt = $pdo->prepare("DELETE FROM meetings WHERE meeting_id = ?");
    $stmt->execute([$meeting_id]);

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "Meeting deleted successfully"
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
}
