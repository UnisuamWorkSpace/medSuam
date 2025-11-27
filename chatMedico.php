<?php
session_start();
include "dbMedsuam.php";



// POST variables from previous page
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['consulta'])) {
    $consulta = mysqli_real_escape_string($conn, $_POST['consulta']);   // appointment_id
    $idpaciente = mysqli_real_escape_string($conn, $_POST['paciente']); // receiver_id
    $nomePaciente = mysqli_real_escape_string($conn, $_POST['nomePaciente']);
    /* $parts = explode(" ", $nomePaciente); // splits by space
    $nomePaciente = $parts[0];           // take the first part */
    $sql = "SELECT status FROM consulta WHERE id_consulta = $consulta";
    $result =  mysqli_query($conn, $sql);
    $account = mysqli_fetch_assoc($result);
    if($account['status'] === "finalizado") {
       header('location: medicopage.php');
    } 
}elseif ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['nivelRisco'])) {
    $nivelRisco = mysqli_real_escape_string($conn, $_POST['nivelRisco']);
    $idpaciente = mysqli_real_escape_string($conn, $_POST['idpaciente']);
    $consulta   = mysqli_real_escape_string($conn, $_POST['consulta']); // <-- FIXED

    $sql = "SELECT * FROM assistente_medico WHERE id_paciente = $idpaciente LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) === 1) {
        $sql = "UPDATE assistente_medico SET nivel_risco = '$nivelRisco' WHERE id_paciente = $idpaciente";
        $result =  mysqli_query($conn, $sql);
        echo "<script> alert('Nível de risco atualizado com sucesso !') </script>";
    }else {

        $sql = "INSERT INTO assistente_medico (id_paciente, status_monitoramento, nivel_risco) VALUES ($idpaciente, 'ativo' , '$nivelRisco')";
        $result =  mysqli_query($conn, $sql);
        echo "<script> alert('Paciente cadastrado com sucesso !') </script>";
    }

    /* header("Location: chatMedico.php?consulta=$consulta&paciente=$idpaciente");
    exit; */
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-…:contentReference[oaicite:2]{index=2}">


</head>
<form action="" method="post" id="planoGamificadoForm" class="planoGamificadoForm">  
    <button id="closeForm" class="closeForm">
        <i class="bi bi-x-lg closeForm"></i>
    </button>
    <h2>Plano Gamificado</h2>
    <p>Aqui você consegue cadastrar o paciente no plano de monitoramento de glicemia gamificado ou atualizar o nível de risco do paciente.</p>
    <p>Basta selecionar o nível de risco do paciente e clicar "pronto" !</p>
    <div>
    <input type="hidden" name="idpaciente" value="<?php echo $idpaciente; ?>">
    <input type="hidden" name="consulta" value="<?php echo $consulta ?? ''; ?>"> <!-- FIXED HERE -->
    <input type="hidden" name="nomePaciente" value="<?php echo $nomePaciente ?? ''; ?>">
    <input type="hidden" name="paciente" value="<?php echo $idpaciente ?? ''; ?>">

    <label class="agendamentoInput">
        <input type="radio" name="nivelRisco" value="leve" required>
            Leve              
        </label >
        <label class="agendamentoInput">
            <input type="radio" name="nivelRisco" value="moderado" required>
            Moderado
        </label>  
        <label class="agendamentoInput">
            <input type="radio" name="nivelRisco" value="alto" required>
            Alto
        </label>
    </div>
    <input class="prontoBtn" type="submit" value="Pronto">
</form>
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
                <li>
                    <button type="button" id="planoGamificadoBtn" class="linkPage planoGamificadoBtn">
                        <i class="fas fa-robot"></i>
                        Plano-gamificado
                    </button>
                </li>
                <li>
                    <form action="./finalizarConsulta.php" method="post">
                        <input type="hidden" name="finalizarConsulta" value="1">

                        <!-- correct names -->
                        <input type="hidden" name="idpaciente" value="<?php echo $idpaciente ?? ''; ?>">
                        <input type="hidden" name="nomePaciente" value="<?php echo $nomePaciente ?? ''; ?>">
                        <input type="hidden" name="consulta" value="<?php echo $consulta ?? ''; ?>">

                        <button class="finalizarConsultaBtn" name="finalizarConsulta" type="submit">
                            Finalizar Consulta 
                        </button>
                    </form>

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
// ✔ Correct and safe variables
const sender_id      = <?php echo json_encode($idmedico); ?>;
const sender_role    = "medico";
const receiver_id    = <?php echo json_encode($idpaciente ?? 1); ?>;
const appointment_id = <?php echo json_encode($consulta ?? 1); ?>;
const nomePaciente   = <?php echo json_encode($nomePaciente ?? "Paciente"); ?>;

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

            const timeOnly = new Date(msg.sent_at).toLocaleTimeString("pt-BR", {
                hour: "2-digit",
                minute: "2-digit",
            });

            chatBox.innerHTML += `
                <div class="messageContainer ${isMe ? "right" : "left"}">
                    <strong>${isMe ? "Você" : nomePaciente}:</strong> 
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

document.getElementById("message").addEventListener('keydown', function (e) {
    if (e.key === "Enter" && !e.shiftKey) {
        e.preventDefault(); 
        sendMessage();      
    }
});

document.getElementById('closeForm').addEventListener('click', function () {
    document.getElementById('planoGamificadoForm').classList.remove('open');
});

document.getElementById('planoGamificadoBtn').addEventListener('click', function () {
    document.getElementById('planoGamificadoForm').classList.toggle('open');
});
</script>
