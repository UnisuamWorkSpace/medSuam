<?php
    session_start();
    include "dbMedsuam.php";
    $error = "";
    

   /*  if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('location: userpage.php');
    }

    if(isset($_SESSION['logged_in_medico']) && $_SESSION['logged_in_medico'] === true) {
        header('location: medicopage.php');
    } */

    if($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $senha = mysqli_real_escape_string($conn, $_POST["senha"]); 
        $sql = "SELECT * FROM paciente WHERE email_paciente='$email' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        $sql2 = "SELECT * FROM medico WHERE email_medico='$email' LIMIT 1";
        $result2 = mysqli_query($conn, $sql2);

        if(mysqli_num_rows($result) === 1 || mysqli_num_rows($result2) === 1) {
            $status = (mysqli_num_rows($result) === 1 ? '1' : '0') . (mysqli_num_rows($result2) === 1 ? '1' : '0');
            
            switch ($status) {
                case '10':
                    $account = mysqli_fetch_assoc($result);

                    if(password_verify($senha, $account['senha_paciente'])) {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['paciente'] = $account['nome_paciente'];
                        $_SESSION['email'] = $account['email_paciente'];
                        $_SESSION['id'] = $account['id_paciente'];
                        $_SESSION['id_paciente'] = $account['id_paciente'];
                        header('location: autenticacao.php');
                        exit;
                        }else {
                            echo '
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    const errorDiv = document.querySelector(".errorMsgDiv");
                                    if (errorDiv) {
                                    errorDiv.classList.add("showErrorMsg");
                                    setTimeout(() => {
                                        errorDiv.classList.remove("showErrorMsg");
                                    }, 3000);
                                    }
                                });
                            </script>';
                            $error = "Senhas não coincidem";            
                        }
                    break;
                case '01':
                    $account = mysqli_fetch_assoc($result2);

                    if(password_verify($senha, $account['senha_medico'])) {
                    
                    if ($account['status_medico'] === 'ativo') {
                        $_SESSION['logged_in_medico'] = true;
                        $_SESSION['medico'] = $account['nome_medico'];
                        $_SESSION['email'] = $account['email_medico'];
                        $_SESSION['id_medico'] = $account['id_medico'];
                        header('location: autenticacaomedico.php');
                        exit;
                    }else {
                        echo '
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const errorDiv = document.querySelector(".errorMsgDiv");
                                if (errorDiv) {
                                errorDiv.classList.add("showErrorMsg");
                                setTimeout(() => {
                                    errorDiv.classList.remove("showErrorMsg");
                                }, 3000);
                                }
                            });
                        </script>';
                        $error = "usuário nao tem autorização";
                    }
                    }else {
                        echo '
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const errorDiv = document.querySelector(".errorMsgDiv");
                                if (errorDiv) {
                                errorDiv.classList.add("showErrorMsg");
                                setTimeout(() => {
                                    errorDiv.classList.remove("showErrorMsg");
                                }, 3000);
                                }
                            });
                        </script>';
                        $error = "Senhas não coincidem";
                    }
                break;

                case '11':
                    echo "erro de login";
                break;
                
                default:
                    # code...
                    break;
            }

            
        }else {
            echo '
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const errorDiv = document.querySelector(".errorMsgDiv");
                                if (errorDiv) {
                                errorDiv.classList.add("showErrorMsg");
                                setTimeout(() => {
                                    errorDiv.classList.remove("showErrorMsg");
                                }, 3000);
                                }
                            });
                        </script>';
                        $error = "Email não cadastrado";
        }
    }

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSuam</title>
    <link rel="icon" href="./images/ChatGPT Image 11 de out. de 2025, 20_18_05 (1).png">
    <link rel="stylesheet" href="./css/login.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>
<body>
    <main>
        <div class="errorMsgDiv">
            <?php if(isset($error)):?>
                <?php echo $error; ?>
            <?php endif;?>
        </div>
        <div class="formContainer">
            <a href="./index.html"><img class="logoForm" src="./images/logo_branco.png"/></a>
            <h1>Login</h1>
        
            <form id="loginForm" action="login.php" method="post" >  
                <div class="inputContainer">
                    
                        <input class="inputStyle noMarginBot " type="text"  id="emaillogin" name="email" placeholder="Email" onblur="validarEmail()" required>
                        <span  id="emailLoginSpan" class="spanStyle"></span>
                        <div class="senhaContainer">
                        <input class="inputStyle" type="password" minlength="8" maxlength="12" id="senhalogin" name="senha" placeholder="Senha" required>
                        <img id="eyeSenhaLogin" class="eye-slash" onclick="mostrarSenha('senhalogin', 'eyeSenhaLogin')" src="./images/eye-slash.svg"/>
                        </div>
                        <div class="recuperarSenhaContainer">

                            <a href="./emailCollect.php">Esqueceu a senha ?</a>
                        </div>
                        <input id="enviarBtn" class="buttonStyle" type="submit" value="Enviar">
                        <div class="criarConta">
                            <span>Não tem Conta ?</span>
                            <a href="./cadastroCliente.php">Criar conta</a>
                        </div>
                </div>
            </form>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/login.js"></script>

</body>
</html>