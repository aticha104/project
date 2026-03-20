<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

try {

    // เชื่อมต่อฐานข้อมูล
    $conn = new mysqli("localhost", "root", "", "document_meeting");

    if ($conn->connect_error) {
        throw new Exception("เชื่อมต่อฐานข้อมูลไม่ได้: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");

    // อ่าน JSON จาก Vue
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data) {
        throw new Exception("ไม่พบข้อมูล JSON");
    }

    $meeting_id = $data['meeting_id'] ?? null;
    $agendas = $data['agendas'] ?? [];
    $participants = $data['participants'] ?? [];

    if (!$meeting_id) {
        throw new Exception("ไม่พบ meeting_id");
    }

    /* ===============================
       ลบวาระเก่า
    =============================== */

    $delete = $conn->prepare("DELETE FROM agendas WHERE meeting_id = ?");
    if (!$delete) {
        throw new Exception("เตรียมคำสั่ง DELETE ไม่สำเร็จ: " . $conn->error);
    }

    $delete->bind_param("i", $meeting_id);

    if (!$delete->execute()) {
        throw new Exception("ลบข้อมูลเก่าไม่สำเร็จ: " . $delete->error);
    }

    /* ===============================
       บันทึก agendas
    =============================== */

    if (!empty($agendas)) {

        $stmt = $conn->prepare(
            "INSERT INTO agendas (meeting_id, agenda_order, agenda_text)
             VALUES (?, ?, ?)"
        );

        if (!$stmt) {
            throw new Exception("เตรียมคำสั่ง INSERT ไม่สำเร็จ: " . $conn->error);
        }

        foreach ($agendas as $agenda) {

            $order = intval($agenda['agenda_order']);
            $text  = trim($agenda['agenda_text'] ?? "");

            if ($text === "") {
                continue;
            }

            $stmt->bind_param("iis", $meeting_id, $order, $text);

            if (!$stmt->execute()) {
                throw new Exception("บันทึกวาระไม่สำเร็จ: " . $stmt->error);
            }
        }
    }

    /* ===============================
       ลบ participants เก่า
    =============================== */

    $delete_participants = $conn->prepare(
        "DELETE FROM meeting_participants WHERE meeting_id = ?"
    );

    if (!$delete_participants) {
        throw new Exception("เตรียม DELETE participants ไม่สำเร็จ: " . $conn->error);
    }

    $delete_participants->bind_param("i", $meeting_id);
    $delete_participants->execute();


    /* ===============================
       บันทึก participants ใหม่
    =============================== */

    if (!empty($participants)) {

        $stmt_part = $conn->prepare(
            "INSERT INTO meeting_participants
            (meeting_id, person_id, position_id, role_id, status)
            VALUES (?, ?, ?, ?, ?)"
        );

        if (!$stmt_part) {
            throw new Exception("เตรียม INSERT participants ไม่สำเร็จ: " . $conn->error);
        }

        foreach ($participants as $p) {

            $person_id   = intval($p['person_id']);
            $position_id = intval($p['position_id']);
            $role_id     = intval($p['role_id']);
            $status      = $p['status'];

            $stmt_part->bind_param(
                "iiiis",
                $meeting_id,
                $person_id,
                $position_id,
                $role_id,
                $status
            );

            if (!$stmt_part->execute()) {
                throw new Exception("บันทึกผู้เข้าประชุมไม่สำเร็จ: " . $stmt_part->error);
            }
        }
    }

    echo json_encode([
        "success" => true,
        "message" => "บันทึกข้อมูลการประชุมสำเร็จ"
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}