<?php

    session_start();
    require '../dbMedsuam.php';

    $parts = explode(" ", $_SESSION['paciente']); // splits by space
    $primeiroNome = $parts[0];           // take the first part

    if(!isset($_SESSION['logged_in'])) {
        header('location: login.php');
        exit;
    }

    $sql = "SELECT * FROM assistente_medico WHERE id_paciente = {$_SESSION['id']} LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) === 1) {
        $_SESSION['perfilGamificado'] = true;
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
        <div class="acessibilidadeContainer termosPage">
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
                <a href="../userpage.php"><img class="logo" src="../images/Logo_medsuam-removebg-preview (1).png" alt="logo"/></a>
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
                <span>Olá <?php echo $primeiroNome . ' !'?> </span>
            </li>
            <li>
                <a href="../userpage.php" class="linkPage">
                    <i class="fa-solid fa-house"></i>
                    <span>Início</span>
                </a>
            </li>
            <li>
                <a href="./exames.php" class="linkPage">
                    <i class="fa-solid fa-flask"></i>
                    <span>Exames</span>
                </a>
            </li>
            <li>
                <a href="./vacinas.php" class="linkPage">
                    <i class="fas fa-syringe"></i>
                    <span>Vacinas</span>
                </a>
            </li>
            
            <li>
                <a href="./consultas.php" class="linkPage">
                    <i class="fa fa-stethoscope"></i>
                    <span>Consultas</span>
                </a>
            </li>
          
            <li class="geralSpanContainer">
                <span class="geralSpan">Geral</span>
            </li>
            <li>
                <a href="./dadosCadastrais.php" class="linkPage ">
                    <i class="fas fa-gear"></i>
                    <span>Dados Cadastrais</span>
                </a>
            </li>
            <li>
                <a href="#" class="linkPage currentPage">
                <i class="fas fa-book"></i>
                <span>Termos</span>
                </a>
            </li>
            <?php if(isset($_SESSION['perfilGamificado']) && $_SESSION['perfilGamificado']):?>
            <li>
                <a href="../assisMedico.php" id="acessibilidadeLabel" class="linkPage" for="acessibilidade">
                    <i class="fas fa-robot"></i>
                    Plano-gamificado
                </a>
            </li>
            <?php endif;?>
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
    <main id="termos">
  <header>
    <h1>Termos e Condições de Uso – MedSuam</h1>
    <p><strong>Data de vigência:</strong> 11/10/2025</p>
    <p>Bem-vindo(a) à MedSuam! Ao acessar ou utilizar nossos serviços, você concorda com estes Termos e Condições. Leia com atenção.</p>
  </header>

  <section >
    <h2>1. Definições</h2>
    <ul>
      <li><strong>Plataforma / MedSuam:</strong> o site e os sistemas vinculados que oferecem serviços de telemedicina.</li>
      <li><strong>Usuário / Paciente:</strong> pessoa que acessa a plataforma para buscar atendimento de saúde.</li>
      <li><strong>Profissional:</strong> médico, psicólogo, nutricionista ou outro profissional de saúde cadastrado na plataforma.</li>
      <li><strong>Serviços:</strong> consultas, orientações, acompanhamento e demais funcionalidades disponibilizadas pela MedSuam.</li>
      <li><strong>Conta:</strong> cadastro de usuário com login e senha para acesso à plataforma.</li>
    </ul>
  </section>

  <article>
    <h2>2. Objeto</h2>
    <p>A MedSuam disponibiliza uma plataforma para a realização de atendimentos e orientações médicas e de saúde à distância, por meio de videochamadas, chat ou outros meios virtuais, entre Usuários e Profissionais, conforme as especialidades oferecidas.</p>
  </article>

  <article>
    <h2>3. Cadastro e Conta de Usuário</h2>
    <ul>
      <li>Para usar os serviços, o Usuário deve criar uma conta com e-mail válido, senha e demais dados solicitados.</li>
      <li>É de responsabilidade do Usuário manter seus dados de acesso (login e senha) em sigilo.</li>
      <li>O Usuário concorda em fornecer informações verdadeiras, completas e atualizadas.</li>
      <li>A MedSuam poderá suspender ou encerrar contas que violem estes Termos ou façam uso indevido da plataforma.</li>
    </ul>
  </article>

  <article>
    <h2>4. Serviços Oferecidos</h2>
    <ul>
      <li>Consulta médica online em diversas especialidades (Clínica Geral, Pediatria, Dermatologia, Ginecologia, Urologia, Psicologia etc.)</li>
      <li>Acompanhamento e orientação de tratamento</li>
      <li>Disponibilização de prontuário eletrônico</li>
      <li>Chat ou mensagens para esclarecimento de dúvidas entre usuário e profissional</li>
      <li>Funcionalidades de gamificação para engajar o usuário no acompanhamento do tratamento</li>
    </ul>
  </article>

  <article>
    <h2>5. Uso do Serviço e Restrições</h2>
    <ul>
      <li>Os serviços da MedSuam são para orientação à distância e não substituem consulta presencial quando esta for necessária.</li>
      <li>A plataforma não se responsabiliza por diagnósticos imprecisos decorrentes de limitações do atendimento remoto.</li>
      <li>É vedado ao Usuário usar a plataforma para fins ilegais, ofensivos, difamatórios ou que violem direitos de terceiros.</li>
      <li>O Usuário não pode compartilhar sua conta com terceiros.</li>
    </ul>
  </article>

  <article>
    <h2>6. Pagamento, Custo e Cancelamento</h2>
    <ul>
      <li>Caso a plataforma adote modelo pago, o Usuário concorda em pagar os valores anunciados para cada serviço.</li>
      <li>As formas de pagamento (cartão, Pix, boleto etc.) devem seguir os meios disponíveis na plataforma.</li>
      <li>O Usuário pode solicitar cancelamento ou reembolso dentro das condições especificadas pela plataforma (ex: prazo de 24h antes da consulta).</li>
      <li>A MedSuam reserva-se o direito de cancelar ou recusar serviços em caso de suspeita de fraude.</li>
    </ul>
  </article>

  <article>
    <h2>7. Privacidade e Proteção de Dados</h2>
    <ul>
      <li>A MedSuam coleta dados pessoais e sensíveis (como informações médicas) para prestar os serviços.</li>
      <li>Os dados são armazenados de forma segura, com criptografia e acesso restrito.</li>
      <li>A plataforma compromete-se a não compartilhar dados com terceiros sem consentimento, salvo obrigações legais.</li>
      <li>O Usuário tem direito de acessar, corrigir ou solicitar exclusão dos seus dados, conforme a LGPD.</li>
    </ul>
  </article>

  <article>
    <h2>8. Propriedade Intelectual</h2>
    <ul>
      <li>Todo o conteúdo da plataforma (textos, imagens, códigos, marca MedSuam) é de propriedade exclusiva da MedSuam ou titular autorizado.</li>
      <li>É proibida reprodução, cópia ou distribuição não autorizada.</li>
      <li>O Usuário poderá publicar avaliações ou comentários, desde que não infrinjam direitos de terceiros e não contenham conteúdo ofensivo.</li>
    </ul>
  </article>

  <article>
    <h2>9. Responsabilidade e Limitações</h2>
    <ul>
      <li>A MedSuam não garante que os serviços estarão livres de erros, interrupções ou disponibilidade contínua.</li>
      <li>A MedSuam não será responsabilizada por danos indiretos, lucros cessantes ou perdas decorrentes do uso da plataforma.</li>
      <li>O Usuário reconhece que o atendimento remoto tem limitações e concorda em buscar atendimento presencial se necessário.</li>
    </ul>
  </article>

  <article>
    <h2>10. Modificações dos Termos</h2>
    <ul>
      <li>A MedSuam se reserva o direito de alterar estes Termos e Condições periodicamente.</li>
      <li>As novas versões serão disponibilizadas na plataforma com data de vigência.</li>
      <li>O uso contínuo após alterações implica a aceitação dos novos termos.</li>
    </ul>
  </article>

  <article>
    <h2>11. Legislação Aplicável e Foro</h2>
    <ul>
      <li>Estes Termos obedecem às leis brasileiras, incluindo normas de telemedicina e proteção de dados.</li>
      <li>Fica eleito o foro da Comarca de [Rio de Janeiro – RJ] para dirimir quaisquer disputas, com renúncia a qualquer outro.</li>
    </ul>
  </article>

  <footer>
    <p>&copy; 2025 MedSuam. Todos os direitos reservados.</p>
  </footer>
</main>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../js/userpage.js"></script>

</body>
</html>