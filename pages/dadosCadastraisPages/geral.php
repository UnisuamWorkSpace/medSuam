<?php
    
    include "../../dbMedsuam.php";
    $error = "";
    session_start();

    $sql = "SELECT * FROM paciente WHERE id_paciente={$_SESSION['id']} LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $account = mysqli_fetch_assoc($result);

    $cpf = $account['cpf_paciente'];
    $aniversario = $account['data_nasc_paciente'];
    $dataDoBD = $aniversario;
    $brData = date("d/m/Y", strtotime($dataDoBD));
    $genero = $account['sexo_paciente'];

    $sql2 = "SELECT * FROM rg WHERE paciente_id_paciente={$_SESSION['id']} LIMIT 1";
    $result2 = mysqli_query($conn, $sql2);
    $rgTable = mysqli_fetch_assoc($result2);


    if($_SERVER['REQUEST_METHOD'] === "POST") {

        if(isset($_POST['editarUsuario'])){
            $estadoCivil = mysqli_real_escape_string($conn, $_POST['estadoCivil']);
            $nomeSocial = mysqli_real_escape_string($conn, $_POST['nomeSocial']);
            $numeroRg = mysqli_real_escape_string($conn, $_POST['numeroRg']);
            $dataEmissao = mysqli_real_escape_string($conn, $_POST['dataEmissao']);
            $orgaoEmissor = mysqli_real_escape_string($conn, $_POST['orgaoEmissor']); 
            $ufRg = mysqli_real_escape_string($conn, $_POST['ufRg']); 
            $dataValidade = mysqli_real_escape_string($conn, $_POST['dataValidade']);  
            $sql = "UPDATE paciente SET estado_civil = '$estadoCivil', nome_social_paciente = '$nomeSocial' WHERE id_paciente ={$_SESSION['id']}";
            $result = mysqli_query($conn, $sql);

            $sql2 = "UPDATE rg SET numero_rg = '$numeroRg', data_emissao = '$data_emissao', orgao_emissor = '$orgaoEmissor', uf_rg = '$ufRg', data_validade = '$dataValidade' WHERE paciente_id_paciente ={$_SESSION['id']}";
            $result = mysqli_query($conn, $sql2);
            header('location: geral.php');
            exit;
        }

    }

    $parts = explode(" ", $_SESSION['paciente']); // splits by space
    $primeiroNome = $parts[0];           // take the first part

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
    <link rel="icon" href="../../images/ChatGPT Image 11 de out. de 2025, 20_18_05 (1).png">
    <link rel="stylesheet" href="../../css/userpage.css"/>  
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
                <a href="../../userpage.php"><img class="logo" src="../../images/Logo_medsuam-removebg-preview (1).png" alt="logo"/></a>
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
                <a href="../../userpage.php" class="linkPage">
                    <i class="fa-solid fa-house"></i>
                    <span>Início</span>
                </a>
            </li>
            <li>
                <a href="../exames.php" class="linkPage">
                    <i class="fa-solid fa-flask"></i>
                    <span>Exames</span>
                </a>
            </li>
            <li>
                <a href="../vacinas.php" class="linkPage">
                    <i class="fas fa-syringe"></i>
                    <span>Vacinas</span>
                </a>
            </li>
            
            <li>
                <a href="../consultas.php" class="linkPage currentPage">
                    <i class="fa fa-stethoscope"></i>
                    <span>Consultas</span>
                </a>
            </li>
          
            <li class="geralSpanContainer">
                <span class="geralSpan">Geral</span>
            </li>
            <li>
                <a href="../dadosCadastrais.php" class="linkPage">
                    <i class="fas fa-gear"></i>
                    <span>Dados Cadastrais</span>
                </a>
            </li>
            <li>
                <a class="linkPage">
                <i class="fas fa-book"></i>
                <span>Termos</span>
                </a>
            </li>
            <?php if(isset($_SESSION['perfilGamificado']) && $_SESSION['perfilGamificado']):?>
            <li>
                <a href="./assisMedico.php" id="acessibilidadeLabel" class="linkPage" for="acessibilidade">
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
                <a id="sairLink" href="../../sair.php">
                    <i class="fas fa-door-open"></i>
                    <span>Sair</span>
                </a>
            </li>
            
        </ul>
        </div>
        
        
    </aside>
    <main>

        <section id="geral" class="twoGrid margin">
            <div class="left">
                <a href="../dadosCadastrais.html" class="backToInicioLink backToDadosCadastrais">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>Voltar para dados cadastrais</span>
                </a>

                <h1>Dados pessoais</h1>

                <div class="linksBar">
                    <a href="#" class="selected">Geral</a>
                    <a href="./saude.php">Saúde</a>
                    <a href="./seusContatos.php">Seus contatos</a>

                </div>

                <form action="geral.php" method="post" class="dadosContainer">
                    <div class="dadosContainerContent">
                        <strong>Nome Legal</strong>
                        <span><?php echo $_SESSION['paciente']?></span>
                    </div>
                    <div class="dadosContainerContent">
                        <strong>Nome Social</strong>
                        <span class="infoSpan"><?php echo $account['nome_social_paciente']?></span>
                        
                        <div class="inputsContainer hide">
                            <input type="text" name="nomeSocial" placeholder="Nome Social" value="<?php echo $account['nome_social_paciente']?>" onkeyup="soLetras(event)">
                            <input type="submit" name="editarUsuario" value="editar">
                        </div>
                       
                        <button type="button" class="editBtn">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                    <div class="dadosContainerContent">
                        <strong>CPF</strong>
                        <span><?php echo $cpf?></span>
                    </div>
                    <div class="dadosContainerContent">
                        <strong>Rg</strong>
                        <span><?php echo $rgTable['numero_rg'] ?? "N/A"?></span>
                        <div class="inputsContainer column hide">
                            <label>Número do RG</label>
                            <input id="rg" type="text" name="numeroRg" placeholder="Número do RG" value="<?php echo $rgTable['numero_rg']?>">
                            <label>Data de emissão</label>
                            <input type="date" name="dataEmissao" placeholder="Data de emissão" value="<?php echo $rgTable['data_emissao']?>">
                            <label>Orgão emissor</label>
                            <input type="text" name="orgaoEmissor" placeholder="Orgão emissor" value="<?php echo $rgTable['orgao_emissor']?>">
                            <label>Estado de emissão</label>
                            <select id="estadocliente" class="inputStyle" name="ufRg" value="<?php echo $rgTable['uf_rg'] ?>">
                            <option value="<?php echo $rgTable['uf_rg'] ?>"><?php echo $rgTable['uf_rg'] ?></option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                        <label>Data de validade</label>
                        <input type="date" name="dataValidade" placeholder="data de validade" value="<?php echo $rgTable['data_validade']?>">
                        <input type="submit" name="editarUsuario" value="editar">
                        </div>
                       
                        <button type="button" class="editBtn">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                   <!--  <div class="dadosContainerContent">
                        <strong>CNH</strong>
                        <span>cnh</span>
                        <button type="button">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div> -->
                    <div class="dadosContainerContent">
                        <strong>Data de nascimento</strong>
                        
                        <span><?php echo $brData ?></span>
                    </div>
                    <div class="dadosContainerContent">
                        <strong>Sexo biológico</strong>
                        <span><?php echo $genero?></span>
                    </div>
                   <!--  <div class="dadosContainerContent">
                        <strong>Identidade de gênero</strong>
                        <span></span>
                        <button type="button">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div> -->
                    <div class="dadosContainerContent">
                        <strong>Estado Civil</strong>  
                        <span class="infoSpan"><?php echo $account['estado_civil']?></span>
                        <div class="inputsContainer hide">
                               
                            <label>
                                <input type="radio" name="estadoCivil" value="solteiro">
                                 Solteiro(a)
                            </label>

                            <label>
                                <input type="radio" name="estadoCivil" value="casado">
                                Casado(a)
                            </label>
                            <input type="submit" name="editarUsuario" value="editar">
                        </div>
                        <button type="button" class="editBtn">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                    <!-- <div class="dadosContainerContent noBorder">
                        <strong>Profisssão</strong>
                        <span><input type="text" name="profissao" value=""></span>
                        <button type="submit" name="editarUsuario">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div> -->
                

                </form>
            </div>
        </section>
    
    </main>

    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <script src="../../js/userpage.js"></script>

</body>
</html>