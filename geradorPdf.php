<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

session_start();
include "dbMedsuam.php";

// Fetch messages
$idConsulta = $_GET['id_consulta'];

$sql = "SELECT * FROM chat_messages WHERE appointment_id = '$idConsulta' ORDER BY sent_at ASC";
$result = $conn->query($sql);

$html = "<h2>Chat entre Médico e Paciente</h2><hr>";

while ($row = $result->fetch_assoc()) {
    $sender = $row['sender_role'] == 'medico' ? 'Médico' : 'Paciente';
    $time = date("d/m/Y H:i", strtotime($row['sent_at']));

    $message = nl2br($row['message']);

    $html .= "
        <p><strong>$sender ($time):</strong><br>{$message}</p>
        <hr>
    ";
}

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("chat-consulta-$idConsulta.pdf", ["Attachment" => false]);

