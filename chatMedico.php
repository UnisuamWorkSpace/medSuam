<?php
session_start();
include "dbMedsuam.php";

// POST variables from previous page
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['consulta'])) {
    $consulta = mysqli_real_escape_string($conn, $_POST['consulta']);   // appointment_id
    $idpaciente = mysqli_real_escape_string($conn, $_POST['paciente']); // receiver_id
}

// logged doctor ID
$idmedico = $_SESSION['id_medico'] ?? 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Médico</title>

    <link rel="stylesheet" href="./css/chat.css">
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
            <input type="text" id="message" placeholder="Digite sua mensagem...">
            <button id="sendBtn"><i class="bi bi-send-arrow-up-fill"></i></button>
        </div>
    </main>
</body>
</html>

<script>
// ✔ Correct and safe variables
const sender_id      = <?php echo json_encode($idmedico); ?>;
const sender_role    = "medico";
const receiver_id    = <?php echo json_encode($idpaciente ?? 1); ?>;
const appointment_id = <?php echo json_encode($consulta ?? 1); ?>;

// Load messages every 2 seconds
setInterval(loadMessages, 2000);
loadMessages();

function loadMessages() {
    fetch("http://localhost/medSuam-frontend/getMessages.php?appointment_id=" + appointment_id)
    .then(r => r.json())
    .then(data => {
        let chatBox = document.getElementById("chatBox");
        chatBox.innerHTML = "";

        data.forEach(msg => {

            // ✔ Correctly check role + ID
            const isMe = msg.sender_id == sender_id && msg.sender_role === "medico";

            chatBox.innerHTML += `
                <div class="messageContainer ${isMe ? "right" : "left"}">
                    <strong>${isMe ? "Você" : "Paciente"}:</strong> 
                    ${msg.message}
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
    formData.append("sender_role", sender_role); // ✔ very important
    formData.append("receiver_id", receiver_id);
    formData.append("appointment_id", appointment_id);
    formData.append("message", text);

    fetch("http://localhost/medSuam-frontend/sendMessages.php", {
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
</script>
