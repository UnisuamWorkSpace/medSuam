<?php
session_start();
include "../dbMedsuam.php";
$consultas = [];

        $sql = "SELECT 
            c.*, 
            m.nome_medico, 
            e.nome AS especialidade
        FROM consulta AS c
        INNER JOIN medico AS m ON c.id_medico = m.id_medico
        INNER JOIN especialidade AS e ON e.id_medico = m.id_medico
        WHERE c.id_paciente = '{$_SESSION['id']}'
        ORDER BY c.data_consulta DESC, c.hora_consulta DESC";


    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 0) {
        $consultas = [];
    } else {
         
        while ($row = mysqli_fetch_assoc($result)) {
            $consultas[] = $row;
        }
        $totalConsultas = count($consultas);
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
         <section id="consultas" class="margin twoGrid hideableDiv"> 
            <div class="left">
            <h1>Seus Atalhos</h1>
            <div class="twoCards">
                
                <button type="button" class="cardContainer agendarEspecialidade">
                    <div class="cardContent ">
                        <i class="bi bi-heart-pulse"></i>
                        <span>Agendar Especialidade</span>
                    </div>
                </button>
            
                
                <a href="./consultaonline.php" class="cardContainer consultaOnline">
                    <div class="cardContent">
                        <i class="bi bi-camera-video"></i>
                        <span>Consulta online 24h</span>
                    </div>
                </a>
            </div>

            <!-- <div class="alterPacientContainer vacinasAlterPacientContainer">
                <button type="button" id="alterPacientBtn3" class="alterPacientBtn">
                    <strong>Nome</strong>
                    <span>• Alterar</span>
                    <i class="fa-solid fa-angle-down"></i>
                </button>
                <div class="pacienteContainer">
                    <h3>Selecione um paciente</h3>
                    <div class="paciente">
                        <strong>Nome Completo</strong>
                        <span>Você, idade</span>
                    </div>
                    <button type="button" class="dependenteBtn">
                        <span>+Cadastrar paciente</span>
                    </button>
                </div>
            </div> -->

            <p class="centralizado">Consultas realizadas</p>

            <?php foreach ($consultas as $row): ?>
                <div class="resultadosContainer ">
                    <div class="left statusConsultaPaciente">
                        <span><?php echo htmlspecialchars($row['status']);?></span>
                    </div>
                    <div class="topRight">
                        <h3>Data: <?php echo htmlspecialchars(date("d/m/Y", strtotime($row['data_consulta']))); ?></h3>
                        <span class="horaConsulta">Hora: <?php echo htmlspecialchars(date('H:i', strtotime($row['hora_consulta'])));?></span>
                        <span class="docName">Médico: Dr(a) <?php echo htmlspecialchars($row['nome_medico']); ?></span>
                        <div class="gapBetween">
                            <i class="bi bi-clipboard2-pulse"></i>
                            <span><?php echo htmlspecialchars($row['id_consulta']); ?></span>
                        </div>
                        <hr>
                    </div>
                    
                    <div class="bottomRight spaceBetween">
                        <a href="#" class="hide">Compartilhar</a>
                        <form action="../chat.php" method="post">
                            <input type="hidden" name="idMedico"  value="<?php echo htmlspecialchars($row['id_medico']); ?>">
                            <button type="submit" class="mostrarResultadosBtn" name="consulta" value="<?php echo htmlspecialchars($row['id_consulta']); ?>">
                                Mostrar Resultados
                            </button>
                        </form>
                    </div>

                </div>
                <br>
            <?php endforeach; ?>
            </div>

            <div class="right centralizado">
                <p>Nenhuma consulta selecionada</p>
            </div>

        </section>

          <section class="dynamicSection twoGrid margin"></section>
    </main>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../js/userpage.js"></script>

</body>
</html>