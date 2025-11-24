<?php

// session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use SendGrid\Mail\Mail;

// Carregando as váriáveis do arquivo .env;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Pega as variáveis do ambiente do Dotenv diretamente;
$env = $_ENV;


// Função para gerar um código 2FA;
function generate2FACode($length = 6) {
    // Gerando um código numérico aleatório de $length dígitos;
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= random_int(0, 9);
    }
    
    // Armazenando o código gerado na sessão com timestamp de expiração;
    $_SESSION['2fa_code'] = $code;
    $_SESSION['2fa_code_time'] = time();
    $_SESSION['2fa_attempts'] = 0; // Resetar tentativas;
    
    return $code;
}

// Função para enviar um email;
function send2FACode($email, $sendCode = true) {
    $SENDGRID_API_KEY = $_ENV['SENDGRID_API_KEY'] ?? null;
    if (!$SENDGRID_API_KEY) {
        error_log("2FA: Chave API do SendGrid não configurada");
        return false;
    }
    if ($sendCode) {
        // Verificando se existe código na sessão;
        if (!isset($_SESSION['2fa_code'])) {
            error_log("2FA: Nenhum código gerado para enviar");
            return false;
        }

        // Recuperando o código da sessão;
        $code = $_SESSION['2fa_code'];
    
        // Configurações do email a ser enviado para o usuário com o código 2FA;
        $to = $email;
        $subject = "Seu código de verificação - " . $_SERVER['HTTP_HOST'];
        $message = "
        <html>
        <head>
            <title>Código de Verificação</title>
            <style>
                body { font-family: Arial, sans-serif; }
                .code { 
                    font-size: 24px; 
                    font-weight: bold; 
                    color: #2c3e50; 
                    background: #f8f9fa; 
                    padding: 10px 20px; 
                    border-radius: 5px;
                    display: inline-block;
                    margin: 10px 0;
                }
                .warning { 
                    color: #e74c3c; 
                    font-size: 12px; 
                    margin-top: 20px;
                }
            </style>
        </head>
        <body>
            <h2>Verificação em Duas Etapas</h2>
            <p>Use o código abaixo para completar seu login:</p>
            <div class='code'>{$code}</div>
            <p>Este código expirará em 10 minutos.</p>
            <p class='warning'>Se você não solicitou este código, ignore este email.</p>
        </body>
        </html>
        ";
    } else {
        // Preparei essa parte para quando for necessário enviarmos outros tipos de email usando a mesma função, como por exemplo o email de recuperação de senha.
        error_log("2FA: Envio de código desativado por configuração");
        return false;
    }


    $mail = new Mail();
    $mail->setFrom("medsuam@gmail.com", "Código de Verificação");
    $mail->setSubject("Seu código de verificação - MedSuam");
    // $mail->addReplyTo("medsuam@gmail.com", "Suporte MedSuam");
    $mail->addTo($email, $email);
    $mail->addContent("text/plain", "Seu código 2FA: $code (válido 10 minutos)");
    $mail->addContent("text/html", $message);

    $sendgrid = new \SendGrid($SENDGRID_API_KEY);

    try {
        $response = $sendgrid->send($mail);
        $status = $response->statusCode();
        if ($status >= 200 && $status < 300) {
            error_log("2FA: Código enviado para {$email} via SendGrid");
            return true;
        } else {
            error_log("2FA: Falha ao enviar código para {$email}");
            return false;
        }
    } catch (Exception $e) {
        error_log("2FA: Erro ao enviar código para {$email} - " . $e->getMessage());
        return false;
    }

}

// Função para verificar o código 2FA fornecido pelo usuário;
function verify2FACode($inputCode, $expiryTime = 600, $maxAttempts = 5) {
    
    // Inicializando o contador de tentativas se não existir;
    if (!isset($_SESSION['2fa_attempts'])) {
        $_SESSION['2fa_attempts'] = 0;
    }
    
    // Verificando se o número de tentativas foi atingido e retornando uma mensagem de erro se tiver atingido o número máximo de tentativas;
    if ($_SESSION['2fa_attempts'] >= $maxAttempts) {
        return [
            'success' => false,
            'message' => 'Número máximo de tentativas excedido. Gere um novo código.'
        ];
    }

    // Incrementando o contador de tentativas;
    $_SESSION['2fa_attempts']++;

    // Verificando se existe código na sessão;
    if (!isset($_SESSION['2fa_code']) || !isset($_SESSION['2fa_code_time'])) {
        return [
            'success' => false,
            'message' => 'Código não encontrado. Solicite um novo código.'
        ];
    }
    
    $storedCode = $_SESSION['2fa_code'];
    $codeTime = $_SESSION['2fa_code_time'];

    // Verificando se o código expirou e limpando a sessão se sim, retornando uma mensagem de erro com o motivo da expiração;
    if ((time() - $codeTime) > $expiryTime) {
        clear2FASession();
        return [
            'success' => false,
            'message' => 'Código expirado. Solicite um novo código.'
        ];
    }
    
    // Comparando os códigos e removendo espaços e letras maiúsculas/minúsculas para evitar erros de digitação;
    $cleanInput = preg_replace('/\s+/', '', $inputCode);
    $cleanStored = preg_replace('/\s+/', '', $storedCode);
    
    if ($cleanStored === $cleanInput) {
        // Código válidado - limpar sessão 2FA;
        clear2FASession();
        $_SESSION['2fa_verified'] = true;
        $_SESSION['2fa_verified_time'] = time();
        
        return [
            'success' => true,
            'message' => 'Código verificado com sucesso!'
        ];
    } else if($cleanInput === '000000'){
        // Código de bypass para testes - limpar sessão 2FA;
        clear2FASession();
        $_SESSION['2fa_verified'] = true;
        $_SESSION['2fa_verified_time'] = time();
        
        return [
            'success' => true,
            'message' => 'Código verificado com sucesso!'
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Código inválido. Tentativas restantes: ' . ($maxAttempts - $_SESSION['2fa_attempts']),
            'attempts_remaining' => $maxAttempts - $_SESSION['2fa_attempts']
        ];
    }
}

// Função para limpar os dados 2FA da sessão;
function clear2FASession() {
    unset($_SESSION['2fa_code']);
    unset($_SESSION['2fa_code_time']);
    unset($_SESSION['2fa_attempts']);
}

// Função para verificar se o usuário já passou pela verificação 2FA recentemente;
function is2FAVerified($maxAge = 300) {
    return isset($_SESSION['2fa_verified']) && 
           $_SESSION['2fa_verified'] === true &&
           (time() - $_SESSION['2fa_verified_time']) <= $maxAge;
}
?>