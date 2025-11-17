<?php
session_start();
include "dbMedsuam.php";

header("Content-Type: text/plain");

// 1. Must be POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "ERROR: Not POST";
    exit;
}

echo "POST RECEIVED:\n";
print_r($_POST);

// 2. Check required fields
if (!isset($_POST['sender_id'], $_POST['receiver_id'], $_POST['appointment_id'], $_POST['message'], $_POST['sender_role'])) {
    echo "\nERROR: Missing fields";
    exit;
}

// 3. Sanitize
$sender = intval($_POST['sender_id']);
$receiver = intval($_POST['receiver_id']);
$appointment = intval($_POST['appointment_id']);
$message = trim($_POST['message']);
$sender_role = mysqli_real_escape_string($conn, $_POST['sender_role']); // "medico" or "paciente"

echo "\nParsed values:\n";
echo "sender = $sender\n";
echo "receiver = $receiver\n";
echo "appointment = $appointment\n";
echo "role = $sender_role\n";
echo "message = $message\n";

// 4. Insert using prepared statement
$stmt = $conn->prepare("
    INSERT INTO chat_messages (sender_id, sender_role, receiver_id, appointment_id, message)
    VALUES (?, ?, ?, ?, ?)
");

if (!$stmt) {
    echo "\nPrepare failed: " . $conn->error;
    exit;
}

$stmt->bind_param("isiss", $sender, $sender_role, $receiver, $appointment, $message);

if ($stmt->execute()) {
    echo "\nRESULT: OK";
} else {
    echo "\nRESULT: ERROR: " . $stmt->error;
}
