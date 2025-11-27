<?php
session_start();
include "dbMedsuam.php";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['consulta'])) {
    $consulta = mysqli_real_escape_string($conn, $_POST['consulta']); 
    $idMedico = mysqli_real_escape_string($conn, $_POST['idMedico']);  
    $nomeMedico = mysqli_real_escape_string($conn, $_POST['nomeMedico']);
    $parts = explode(" ", $nomeMedico); // splits by space
    $nomeMedico = $parts[0];           // take the first part
    
    // Verifica se a consulta já foi finalizada
    $sql = "SELECT status FROM consulta WHERE id_consulta = $consulta";
    $result =  mysqli_query($conn, $sql);
    $account = mysqli_fetch_assoc($result);
    if($account['status'] === "Finalizado") {
       header('location: userpage.php');
    } 
}

$idPaciente = $_SESSION['id'] ?? 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Paciente</title>

    <link rel="stylesheet" href="./css/chat.css">
    <link rel="icon" type="image/png" href="./images/pacient_balloon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <aside>
        <div class="background">
            <ul>
                <li>
                    <div class="menuIconContainer">
                        <a href="#">
                            <img class="logo" src="./images/Logo_medsuam-removebg-preview (1).png" alt="logo"/>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </aside>

    <main>
        <div id="chatBox"></div>

        <div class="inputBox">
            <textarea  id="message" placeholder="Digite sua mensagem..."></textarea>
            <button id="sendBtn"><i class="bi bi-send-arrow-up-fill"></i></button>
        </div>
    </main>
</body>
</html>

<script>

const sender_id      = <?php echo json_encode($idPaciente); ?>;
const sender_role    = "paciente";
const receiver_id    = <?php echo json_encode($idMedico ?? 1); ?>;
const appointment_id = <?php echo json_encode($consulta ?? 1); ?>;
const nomeMedico   = <?php echo json_encode($nomeMedico ?? "Medico"); ?>;
const baseUrl = window.location.origin;
setInterval(loadMessages, 2000);
loadMessages();

function loadMessages() {
    fetch(`${baseUrl}/medSuam/getMessages.php?appointment_id=${appointment_id}`)
    .then(r => r.json())
    .then(data => {
        let chatBox = document.getElementById("chatBox");
        chatBox.innerHTML = "";

        data.forEach(msg => {

            const isMe = msg.sender_id == sender_id && msg.sender_role === "paciente";

            const timeOnly = new Date(msg.sent_at).toLocaleTimeString("pt-BR", {
                hour: "2-digit",
                minute: "2-digit",
            });

            chatBox.innerHTML += `
                <div class="messageContainer ${isMe ? "right" : "left"}">
                    <strong>${isMe ? "Você" : "Dr(a). " + nomeMedico}:</strong> 
                    <p>${msg.message.replace(/\n/g, "<br>")}</p>
                    <span>${timeOnly}</span>
                </div>
            `;
        });

        chatBox.scrollTop = chatBox.scrollHeight;
    });
}


function sendMessage() {
    let text = document.getElementById("message").value.trim();
    if (text === "") return;

    const formData = new FormData();
    formData.append("sender_id", sender_id);
    formData.append("sender_role", sender_role);
    formData.append("receiver_id", receiver_id);
    formData.append("appointment_id", appointment_id);
    formData.append("message", text);

    fetch(`${baseUrl}/medSuam/sendMessages.php`, {
        method: "POST",
        body: formData
    })
    .then(r => r.text())
    .then(t => {
        console.log("SERVER RESPONSE:", t);
        document.getElementById("message").value = "";
        loadMessages();
    });
}

document.getElementById("sendBtn").onclick = sendMessage;

document.getElementById("message").addEventListener('keydown', function (e) {
    if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault(); 
        sendMessage();      
    }
});
</script>
