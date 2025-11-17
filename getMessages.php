<?php
header('Content-Type: application/json');
include "dbMedsuam.php";

if (!isset($_GET['appointment_id'])) {
    echo json_encode([]);
    exit;
}

$appointment = intval($_GET['appointment_id']);

$stmt = $conn->prepare("
    SELECT 
        id,
        sender_id,
        sender_role,
        receiver_id,
        message,
        appointment_id,
        sent_at
    FROM chat_messages
    WHERE appointment_id = ?
    ORDER BY sent_at ASC
");
$stmt->bind_param("i", $appointment);
$stmt->execute();

$result = $stmt->get_result();
$messages = [];

while ($row = $result->fetch_assoc()) {
    // Return only what the frontend needs
    $messages[] = [
        "id" => $row["id"],
        "sender_id" => $row["sender_id"],
        "sender_role" => $row["sender_role"], // IMPORTANT
        "receiver_id" => $row["receiver_id"],
        "message" => $row["message"],
        "sent_at" => $row["sent_at"]
    ];
}

echo json_encode($messages);
