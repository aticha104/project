<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

try {

    if (!isset($_GET['meeting_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "meeting_id required"
        ]);
        exit;
    }

    $meeting_id = $_GET['meeting_id'];

    /* ===== ดึงข้อมูลการประชุม ===== */

    $sql = "SELECT * FROM meetings WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$meeting_id]);

    $meeting = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$meeting) {
        echo json_encode([
            "success" => false,
            "message" => "ไม่พบข้อมูลการประชุม"
        ]);
        exit;
    }

    /* ===== ดึงวาระ ===== */

    $sql2 = "

    SELECT agenda_order, agenda_text
    FROM agendas
    WHERE meeting_id = ?
    ORDER BY agenda_order ASC

    ";

    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$meeting_id]);

    $agendas = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    $meeting['agendas'] = $agendas;

    /* ===== ดึงผู้เข้าประชุม ===== */

    $sql3 = "

    SELECT 
    mp.*,
    r.name AS role_name

    FROM meeting_participants mp

    LEFT JOIN roles r
    ON mp.role_id = r.id

    WHERE mp.meeting_id = ?

    ";

    $stmt3 = $pdo->prepare($sql3);
    $stmt3->execute([$meeting_id]);

    $participants = $stmt3->fetchAll(PDO::FETCH_ASSOC);

    $meeting['participants'] = $participants;

    /* ===== ส่งข้อมูล ===== */

    echo json_encode([
        "success" => true,
        "data" => $meeting
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);

}