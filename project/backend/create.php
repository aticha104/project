<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once "db.php";

try {

    $raw = file_get_contents("php://input");
    $data = json_decode($raw, true);

    if (!$data) {
        throw new Exception("Invalid JSON");
    }

    $meeting_title     = $data['meeting_title'] ?? '';
    $meeting_date      = $data['meeting_date'] ?? '';
    $meeting_time      = $data['meeting_time'] ?? '';
    $meeting_time_end  = $data['meeting_time_end'] ?? '';
    $meeting_at        = $data['meeting_at'] ?? '';
    $participants      = $data['participants'] ?? [];
    $absentees         = $data['absentees'] ?? [];

    if (!$meeting_title || !$meeting_date) {
        throw new Exception("ข้อมูลไม่ครบ");
    }

    // เริ่ม Transaction
    $pdo->beginTransaction();

    // 1️⃣ Insert meeting
    $stmt = $pdo->prepare("
        INSERT INTO meetings
        (meeting_title, meeting_date, meeting_time, meeting_time_end, meeting_at)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $meeting_title,
        $meeting_date,
        $meeting_time,
        $meeting_time_end,
        $meeting_at
    ]);

    $meeting_id = $pdo->lastInsertId();

    // 2️⃣ Insert attendees
    $stmtAttend = $pdo->prepare("
        INSERT INTO meeting_attendees
        (meeting_id, person_id, role_id, attendance_status)
        VALUES (?, ?, ?, ?)
    ");

    foreach ($participants as $p) {
        $stmtAttend->execute([
            $meeting_id,
            $p['id'],
            $p['role_id'],
            "present"
        ]);
    }

    foreach ($absentees as $p) {
        $stmtAttend->execute([
            $meeting_id,
            $p['id'],
            $p['role_id'],
            "absent"
        ]);
    }

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "meeting_id" => $meeting_id
    ]);

} catch (Throwable $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
