<?php 

    include '../dbMedsuam.php';
    session_start();

    $parts = explode(" ", $_SESSION['paciente']);
    $primeiroNome = $parts[0];           

    if(!isset($_SESSION['logged_in'])) {
        header('location: login.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['idMedico'])) {

        $idMedico = mysqli_real_escape_string($conn, $_POST['idMedico']);
        $nomeMedico = mysqli_real_escape_string($conn, $_POST['nomeMedico']);
        $especialidade = mysqli_real_escape_string($conn, $_POST['especialidadeMedico']);

        if(isset($_POST['agendarConsulta'])){
            $idMedico = mysqli_real_escape_string($conn, $_POST['idMedico']);
            $dataConsulta = mysqli_real_escape_string($conn, $_POST['dataAgendamento']);
            $horaConsulta = mysqli_real_escape_string($conn, $_POST['agendamento']);

            $sql = "INSERT INTO consulta (id_paciente, id_medico, data_consulta, hora_consulta, status) VALUES('{$_SESSION['id']}', '$idMedico', '$dataConsulta', '$horaConsulta', 'aguardando')";
            if(mysqli_query($conn, $sql)) {
                echo "telefone INSERTED";
                header('location: consultas.html');
                exit;
            }else {
                echo 'telefone deu erro';
             }
        }



    }
  
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSuam</title>
    <script>
        if(JSON.parse(localStorage.getItem("isDark"))) {
            console.log(JSON.parse(localStorage.getItem("isDark")));
            document.documentElement.classList.add("dark");
        }
    </script>
    <link rel="icon" href="../images/ChatGPT Image 11 de out. de 2025, 20_18_05 (1).png">
    <link rel="stylesheet" href="../css/userpage.css"/>  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-…(hash)…" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Dots:wght@400..700&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>   
    <input type="checkbox" id="acessibilidade">
    <input type="checkbox" id="sidebar">
    <input type="checkbox" id="showMenu">
    <aside>
        <div class="acessibilidadeContainer">
            <button class="darkMode acessibilityBtn" onclick="darkMode()">
                <i class="fas fa-adjust"></i>
            </button>
            <button class="aumentarFonte acessibilityBtn"  onclick="increaseFont()">A+</button>
            <button class="diminuirFonte acessibilityBtn" onclick="decreaseFont()">A -</button>
        </div>
        <div class="background">
        <ul>
            <li>
                <div class="menuIconContainer">
                <a href="../userpage.html"><img class="logo" src="../images/Logo_medsuam-removebg-preview (1).png" alt="logo"/></a>
                 <label for="sidebar" class="menuIcon">
                    <i class="fas fa-angle-double-left"></i>                                                                                                                    
                </label>
                </div>
            </li>
            <li class="showMenuContainer">
                <label for="showMenu">
                    <i class="fas fa-angle-double-up"></i> 
                </label>
            </li>
            <li>
                <a href="../userpage.html" class="linkPage">
                    <i class="fa-solid fa-house"></i>
                    <span>Início</span>
                </a>
            </li>
            <li>
                <a href="./exames.html" class="linkPage">
                    <i class="fa-solid fa-flask"></i>
                    <span>Exames</span>
                </a>
            </li>
            <li>
                <a href="./vacinas.html" class="linkPage">
                    <i class="fas fa-syringe"></i>
                    <span>Vacinas</span>
                </a>
            </li>
            
            <li>
                <a href="./consultas.html" class="linkPage currentPage">
                    <i class="fa fa-stethoscope"></i>
                    <span>Consultas</span>
                </a>
            </li>
          
            <li class="geralSpanContainer">
                <span class="geralSpan">Geral</span>
            </li>
            <li>
                <a href="./dadosCadastrais.html" class="linkPage">
                    <i class="fas fa-gear"></i>
                    <span>Dados Cadastrais</span>
                </a>
            </li>
            <li>
                <a href="./termos.html" class="linkPage">
                <i class="fas fa-book"></i>
                <span>Termos</span>
                </a>
            </li>
            <li>
                <label id="acessibilidadeLabel" class="linkPage" for="acessibilidade">
                    <i class="fa fa-universal-access"></i>
                    <span>Acessibilidade</span>
                </label>
            </li>
            <li class="sairContainer">
                <a id="sairLink" href="../index.html">
                    <i class="fas fa-door-open"></i>
                    <span>Sair</span>
                </a>
            </li>
            
        </ul>
        </div>
        
        
    </aside>
    <main>
         <section id="consultaOnline" class="margin hideableDiv"> 
            <h1>Resultados para:</h1>
            <p>Dr(a) <?php echo htmlspecialchars($nomeMedico)?></p>
            <p><?php echo htmlspecialchars($especialidade)?></p>
            <form class="dataAgendamentoContainer" action="" method="post">
                <input type="hidden" name="idMedico" value="<?php echo htmlspecialchars($idMedico); ?>">
                <input class="dataAgendamento" type="date" name="dataAgendamento" id="hoje" readonly>
                <div class="horarioAgendamento">
                    <label>
                        <input class="agendamentoInput" type="radio" name="agendamento" value="11:00" required>
                        11:00
                    </label>
                    <label>
                        <input class="agendamentoInput" type="radio" name="agendamento" value="14:00" required>
                        14:00
                    </label>  
                    <label>
                        <input class="agendamentoInput" type="radio" name="agendamento" value="17:00" required>
                        17:00
                    </label>
                    <label>
                        <input class="agendamentoInput" type="radio" name="agendamento" value="20:00" required>
                        20:00
                    </label>
                    <label>
                        <input class="agendamentoInput" type="radio" name="agendamento" value="22:00" required>
                        22:00
                    </label>

                    <input class="agendarConsultaBtn" type="submit" name="agendarConsulta" value="Agendar consulta">
                </div>         
            </form>
            <form class="dataAgendamentoContainer" action="" method="post">
                <input type="hidden" name="idMedico" value="<?php echo htmlspecialchars($idMedico); ?>">
                <input class="dataAgendamento" type="date" name="dataAgendamento" id="amanha" readonly>
                <div class="horarioAgendamento">
                    <label>
                        <input class="agendamentoInput" type="radio" name="agendamento" value="11:00" required>
                        11:00
                    </label>
                    <label>
                        <input class="agendamentoInput" type="radio" name="agendamento" value="14:00" required>
                        14:00
                    </label>  
                    <label>
                        <input class="agendamentoInput" type="radio" name="agendamento" value="17:00" required>
                        17:00
                    </label>
                    <label>
                        <input class="agendamentoInput" type="radio" name="agendamento" value="20:00" required>
                        20:00
                    </label>
                    <label>
                        <input class="agendamentoInput" type="radio" name="agendamento" value="22:00" required>
                        22:00
                    </label>
                    <input class="agendarConsultaBtn" type="submit" name="agendarConsulta" value="Agendar consulta">
                </div>         
            </form>
            
            <form class="dataAgendamentoContainer" action="" method="post">
                <input type="hidden" name="idMedico" value="<?php echo htmlspecialchars($idMedico); ?>">
                <input class="dataAgendamento" type="date" name="dataAgendamento" id="depoisDeAmanha" readonly>
                <div class="horarioAgendamento">
            
                    <input type="text" name="agendamento" id="agendamento" requried>
                    <input class="agendarConsultaBtn" type="submit" name="agendarConsulta" value="Agendar consulta">
                </div>         
            </div>
            
            
            

          <section class="dynamicSection twoGrid margin"></section>
    </main>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <script src="../js/userpage.js"></script>

</body>
</html>