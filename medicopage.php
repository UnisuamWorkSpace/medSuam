<?php
    include 'dbMedsuam.php';
    session_start();
    $consultas = [];
    date_default_timezone_set('America/Sao_Paulo');

    $parts = explode(" ", $_SESSION['medico']); // splits by space
    $primeiroNome = $parts[0];           // take the first part

    if(!isset($_SESSION['logged_in_medico'])) {
        header('location: login.php');
        exit;
    }

    $sql = "SELECT 
            c.*, 
            p.nome_paciente
        FROM consulta AS c
        INNER JOIN paciente AS p ON c.id_paciente = p.id_paciente
        WHERE id_medico='{$_SESSION['id_medico']}'
        ORDER BY c.data_consulta DESC, c.hora_consulta DESC";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) === 0) {
        $consultas = 0;
    } else {
         
        while ($row = mysqli_fetch_assoc($result)) {
            $consultas[] = $row;
        }
        $totalConsultas = count($consultas);
    }
    
    

    if($_SERVER['REQUEST_METHOD'] === "POST") { 
        $idConsulta = mysqli_real_escape_string($conn, $_POST['idConsulta']);
        if(isset($_POST['recusar'])) {     
            $sql = "UPDATE consulta SET status = 'recusado' WHERE id_consulta =$idConsulta";
            $result = mysqli_query($conn, $sql);
            header('location: medicopage.php');
        }else {
            $sql = "UPDATE consulta SET status = 'confirmado' WHERE id_consulta =$idConsulta";
            $result = mysqli_query($conn, $sql);
            header('location: medicopage.php');
        }
    }    
$sql = "
    SELECT *
    FROM consulta
    WHERE data_consulta = CURDATE()
    AND id_medico='{$_SESSION['id_medico']}'
    AND (status = 'aguardando' OR status = 'confirmado')
    ORDER BY ABS(TIMESTAMPDIFF(SECOND, 
        CONCAT(data_consulta, ' ', hora_consulta), NOW())) ASC
    LIMIT 1
";


$result = mysqli_query($conn, $sql);


if ($row = mysqli_fetch_assoc($result)) {
    $hora = date('H:i', strtotime($row['hora_consulta']));
} else {
    $hora = "- -";
}

$consultaHoje = [];
$sql = "
    SELECT *
    FROM consulta
    WHERE data_consulta = CURDATE()
    AND id_medico='{$_SESSION['id_medico']}'
    AND (status = 'aguardando' OR status = 'confirmado')
";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 0) {
        $consultaHoje = 0;
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $consultaHoje[] = $row;
        }
        $consultaHoje = count($consultaHoje);
    }

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSuamt</title>
    <script>
        if(JSON.parse(localStorage.getItem("isDark"))) {
            console.log(JSON.parse(localStorage.getItem("isDark")));
            document.documentElement.classList.add("dark");
        }
    </script>
    <link rel="icon" href="./images/ChatGPT Image 11 de out. de 2025, 20_18_05 (1).png">
    <link rel="stylesheet" href="./css/medicopage.css"/>  
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
                <a href="#"><img class="logo" src="./images/Logo_medsuam-removebg-preview (1).png" alt="logo"/></a>
                 <label for="sidebar" class="menuIcon">
                    <i class="fas fa-angle-double-left"></i>                                                                                                                    
                </label>
                </div>
            </li>
            <li>
                <span>Olá <?php echo $primeiroNome . ' !'?> </span>
            </li>
            <li class="showMenuContainer">
                <label for="showMenu">
                    <i class="fas fa-angle-double-up"></i> 
                </label>
            </li>
            <li>
                <a href="#" class="linkPage currentPage">
                    <i class="fa-solid fa-house"></i>
                    <span>Início</span>
                </a>
            </li>
            <li>
                <a href="./pages/exames.html" class="linkPage">
                    <i class="fa-solid fa-flask"></i>
                    <span>Exames</span>
                </a>
            </li>
            <li>
                <a href="./pages/vacinas.html" class="linkPage">
                    <i class="fas fa-syringe"></i>
                    <span>Vacinas</span>
                </a>
            </li>
            
            <li>
                <a href="./pages/consultas.html" class="linkPage">
                    <i class="fa fa-stethoscope"></i>
                    <span>Consultas</span>
                </a>
            </li>
          
            <li class="geralSpanContainer">
                <span class="geralSpan">Geral</span>
            </li>
            <li>
                <a href="./pages/dadosCadastrais.html" class="linkPage">
                    <i class="fas fa-gear"></i>
                    <span>Dados Cadastrais</span>
                </a>
            </li>
            <li>
                <a href="./pages/termos.html" class="linkPage">
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
                <a id="sairLink" href="./sair.php">
                    <i class="fas fa-door-open"></i>
                    <span>Sair</span>
                </a>
            </li>
            
        </ul>
        </div>
        
        
    </aside>
    <main class="mainCentralized">
        <section id="inicioMedico" class="margin hideableDiv">
            <h1> <?php echo $primeiroNome?></h1>
            <span>Hoje você tem <?php echo $consultaHoje?> consultas agendadas</span>
            <div class="consultasInfoContainer">
                <div class="consultasInfo">
                    <h2><?php echo "próxima consulta"; ?></h2>
                    <div>   
                        <i class="bi bi-clock"></i>
                        <span><?php echo $hora; ?></span>
                    </div>
                </div>
                <div class="consultasInfo">
                    <h2><?php echo "Consultas do dia"; ?></h2>
                    <div>
                        <i class="bi bi-calendar-week"></i>
                        <span><?php echo $consultaHoje; ?></span>
                    </div>
                </div>
            </div>

            <div class="consultasBox">
                <p>Consultas</p>
                  
                    <?php if($consultas !== 0): ?>
                        <div class="table-responsive">
                       <table class="consultasTable">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Hora</th>
                                    <th>Status</th>
                                    <th>Editar Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($consultas as $row): ?>
                                    <tr class="resultadosConsultas">
                                        <td class="dataConsulta"><?php echo htmlspecialchars(date("d/m/Y", strtotime($row['data_consulta']))); ?></td>
                                        <td class="horaConsulta"><?php echo htmlspecialchars(date('H:i', strtotime($row['hora_consulta']))); ?></td>
                                        <td><span class="status"><?php echo htmlspecialchars($row['status']); ?></span></td>
                                        <td>
                                            <form action="medicopage.php" method="post" style="display:inline;">
                                                <input type="hidden" name="idConsulta" value="<?php echo htmlspecialchars($row['id_consulta']); ?>">
                                                <div class="actionBtnContainer">
                                                    <button class="editConsultaStatusBtn" type="button">Editar status</button>
                                                    <button class="voltarStatusBtn hide" type="button">Voltar</button>
                                                    <input class="editConsultaRecusarBtn editConsultaBtn hide" type="submit" name="recusar" value="recusar">
                                                    <input class="editConsultaConfirmarBtn editConsultaBtn hide" type="submit" name="confirmar" value="confirmar">
                                                </div>
                                            </form>
                                            <form class="irParaConsultaForm hide" action="./chatMedico.php" method="post">
                                                <input type="hidden" name="consulta" value="<?php echo htmlspecialchars($row['id_consulta']); ?>">
                                                <input type="hidden" name="paciente" value="<?php echo htmlspecialchars($row['id_paciente']); ?>">
                                                <input type="hidden" name="nomePaciente" value="<?php echo htmlspecialchars($row['nome_paciente']); ?>">
                                                <button class="irParaConsultaBtn" type="submit">Ir para Consulta</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                        <span>Você não tem consultas ainda</span>
                    <?php endif; ?>
                
            </div>
        </section>

        <section class="dynamicSection twoGrid margin">
            
        </section>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/medicopage.js"></script>

</body>
</html>