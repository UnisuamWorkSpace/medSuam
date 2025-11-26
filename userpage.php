<?php

    session_start();

    $parts = explode(" ", $_SESSION['paciente']); // splits by space
    $primeiroNome = $parts[0];           // take the first part

    if(!isset($_SESSION['logged_in'])) {
        header('location: login.php');
        exit;
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
    <link rel="icon" href="./images/ChatGPT Image 11 de out. de 2025, 20_18_05 (1).png">
    <link rel="stylesheet" href="./css/userpage.css"/>  
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
                <a href="./pages/consultas.php" class="linkPage">
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
    <main>
        <section id="cards" class="hideableDiv">
            
            <h1>Seus 
                Atalhos</h1>
            <div class="cards">
                
                <button type="button" class="cardContainer pedidosMedicos">
                    <div class="cardContent ">
                        <i class="bi bi-file-text"></i>
                        <span>Pedidos Médicos</span>
                    </div>
                </button>
            
                <button type="button"  class="cardContainer consultas_prescricoes_atestados">
                     <div class="cardContent">
                        <i class="bi bi-file-earmark-medical"></i>
                        <span class="menor">Consultas, Prescrições, Atestados</span>
                    </div>
                </button>
                <button type="button" class="cardContainer agendarExames">
                    <div class="cardContent">
                    <i class="bi bi-calendar2-week"></i>
                        <span>Agendar Exames</span>
                    </div>
                </button>
                <button type="button" class="cardContainer agendarConsultas">
                    <div class="cardContent ">
                        <i class="bi bi-calendar-plus"></i>
                        <span>Agendar Consultas</span>
                    </div>
                </button>
                <button type="button" class="cardContainer resultado_de_exames">
                    <div class="cardContent">
                        <i class="fa-solid fa-flask"></i>
                        <span>Resultados de exames</span>
                    </div>
                </button>
                <button type="button"  class="cardContainer agendarVacina">
                    <div class="cardContent">
                        <i class="fas fa-syringe"></i>
                        <span>Agendar Vacinas</span>
                    </div>
                </button>
                <a href="./pages/consultaonline.php" class="cardContainer consultaOnline">
                    <div class="cardContent">
                        <i class="bi bi-camera-video"></i>
                        <span>Consulta online 24h</span>
                    </div>
    </a>
            </div>
        </section>

        <section class="dynamicSection twoGrid margin">
            
        </section>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/userpage.js"></script>

</body>
</html>