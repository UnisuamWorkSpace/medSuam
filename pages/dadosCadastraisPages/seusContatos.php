<?php
    
    include "../../dbMedsuam.php";
    $error = "";
    session_start();

    $sql = "SELECT * FROM telefone WHERE paciente_id_paciente={$_SESSION['id']} LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $telefoneTable = mysqli_fetch_assoc($result);

    $sql = "SELECT * FROM endereco WHERE paciente_id_paciente={$_SESSION['id']} LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $endereco = mysqli_fetch_assoc($result);

    $sql = "SELECT * FROM paciente WHERE id_paciente={$_SESSION['id']} LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $account = mysqli_fetch_assoc($result);

    if($_SERVER['REQUEST_METHOD'] === "POST") {

        if(isset($_POST['editarUsuario'])){
            $cep = mysqli_real_escape_string($conn, $_POST['cepcliente']);
            $rua = mysqli_real_escape_string($conn, $_POST['ruacliente']);
            $numeroRua = mysqli_real_escape_string($conn, $_POST['numeroruacliente']);
            $complemento = mysqli_real_escape_string($conn, $_POST['complementocliente']);
            $bairro = mysqli_real_escape_string($conn, $_POST['bairrocliente']);
            $cidade = mysqli_real_escape_string($conn, $_POST['cidadecliente']);
            $uf_endereco = mysqli_real_escape_string($conn, $_POST['estado']);

            $celularCliente =mysqli_real_escape_string($conn, $_POST['telefone']);

            $numeroLimpo = preg_replace('/\D/', '', $celularCliente);

            $ddd = substr($numeroLimpo, 0, 2);
            $numero = substr($numeroLimpo, 2);

            $sql = "UPDATE endereco SET cep = '$cep', rua = '$rua', numero = '$numeroRua', complemento = '$complemento', bairro = '$bairro', cidade = '$cidade', uf_endereco = '$uf_endereco'  WHERE paciente_id_paciente ={$_SESSION['id']}";
            $result = mysqli_query($conn, $sql);

            $sql = "UPDATE telefone SET dd = '$ddd', telefone = '$numero' WHERE paciente_id_paciente ={$_SESSION['id']}";
            $result = mysqli_query($conn, $sql);

            header('location: seusContatos.php');
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
                <a href="../userpage.php" class="linkPage">
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

        <section id="seusContatos" class="twoGrid margin">
            <div class="left">
                <a href="../dadosCadastrais.html" class="backToInicioLink backToDadosCadastrais">
                    <i class="bi bi-arrow-left-circle"></i>
                    <span>Voltar para dados cadastrais</span>
                </a>

                <h1>Dados pessoais</h1>

                <div class="linksBar">
                    <a href="./geral.php">Geral</a>
                    <a href="./saude.php">Saúde</a>
                    <a href="./seusContatos.php" class="selected">Seus contatos</a>

                </div>

                <form action="seusContatos.php" method="post" class="dadosContainer">
    
                    <div class="dadosContainerContent">
                        <strong>E-mail</strong>
                        <span class="infoSpan"> <?php echo $account['email_paciente']?></span>
                    </div>
                    <div class="dadosContainerContent">
                        <strong>Telefone</strong>
                        
                        <span class="infoSpan"><?php echo '(' . $telefoneTable['dd'] . ') ' . $telefoneTable['telefone']?></span>
                        <div class="inputsContainer hide">
                            <input type="text" name="telefone" id="telefone" value="<?php echo $telefoneTable['dd'] . ' ' . $telefoneTable['telefone']?>" maxlength="15" >
                            <input type="submit" name="editarUsuario" value="editar">
                        </div>
                            <button type="button" class="editBtn">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        
                    </div>
                    <div class="dadosContainerContent noBorder">
                        <strong>Endereço</strong>
                        <span class="infoSpan">
                            <?php echo $endereco['cep'] . ' ' . $endereco['rua'] . ' ' . $endereco['numero'] . ' ' . $endereco['complemento'] . ' ' . $endereco['bairro'] . ' ' . $endereco['cidade'] . ' ' . $endereco['uf_endereco']   ?> 
                            
                        </span>
                        <div class="inputsContainer column hide">
                        <label>CEP</label>
                        <input class="inputStyle" type="text"  id="cepcliente" name="cepcliente" value="<?php echo $endereco['cep'] ?>" maxlength="9" onkeyup="cepMask(event)" onblur="consultarCep()" required>
                        <span  id="cepSpan" class="spanStyle"></span>
                        <label>Rua</label>
                        <input class="inputStyle" type="text"  id="ruacliente" name="ruacliente" value="<?php echo $endereco['rua'] ?>" required>
                        <label>Numero</label>
                        <input class="inputStyle" type="number"  id="numeroruacliente" name="numeroruacliente" value="<?php echo $endereco['numero'] ?>" required>
                        <label>Complemento</label>
                        <input class="inputStyle" type="text"  id="complementocliente" name="complementocliente" value="<?php echo $endereco['complemento'] ?>">
                        <label>Bairro</label>
                        <input class="inputStyle" type="text"  id="bairrocliente" name="bairrocliente" value="<?php echo $endereco['bairro'] ?>"required>
                        <label>Cidade</label>
                        <input class="inputStyle" type="text"  id="cidadecliente" name="cidadecliente" value="<?php echo $endereco['cidade'] ?>" onkeyup="soLetras(event)" required>
                        <label>Estado</label>
                        <select id="estadocliente" class="inputStyle" name="estado" required>
                            <option value="<?php echo $endereco['uf_endereco'] ?>" selected><?php echo $endereco['uf_endereco'] ?></option>
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
                        <input type="submit" name="editarUsuario" value="editar">
                        </div>
                        <button type="button" class="editBtn">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </div>
                
                </form>
            </div>
        </section>
    
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <script src="../../js/userpage.js"></script>

</body>
</html>