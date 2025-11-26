
<?php
session_start();
require_once 'dbMedsuam.php'; // Arquivo de conexão com o banco

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

/* if (isset($_SESSION['medido'])) {
    header ('location: assisMedico.php');
    exit();
} */

$id_paciente = $_SESSION['id'];

// Buscar a última medição de glicemia do paciente
try {
    // Preparar e executar a consulta usando MySQLi
    $sql = "
        SELECT valor_glicemia, data_medicao, hora_medicao, tipo_medicao 
        FROM medicoes_glicemia 
        WHERE id_paciente = ? 
        ORDER BY data_medicao DESC, hora_medicao DESC 
        LIMIT 1
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_paciente); // "i" significa integer
    $stmt->execute();
    $result = $stmt->get_result();
    $medicao = $result->fetch_assoc();
    
    if (!$medicao) {
        // Se não houver medições, redirecionar para cadastro
        header('Location: registrarGlicemia.php');
        exit();
    }
    
    $valor_glicemia = $medicao['valor_glicemia'];
    $data_medicao = date('d/m/Y', strtotime($medicao['data_medicao']));
    $hora_medicao = date('H:i', strtotime($medicao['hora_medicao']));
    $tipo_medicao = $medicao['tipo_medicao'];
    
    // Determinar status baseado no valor da glicemia 
    // if ($valor_glicemia < 70) {
    //     $status = "Abaixo do ideal";
    //     $mensagem = "Sua glicemia está baixa. Consulte seu médico.";
    //     $classe_status = "baixa";
    // } elseif ($valor_glicemia >= 70 && $valor_glicemia <= 99) {
    //     $status = "Ótimo";
    //     $mensagem = "O seu resultado é excelente!";
    //     $classe_status = "otimo";
    // } elseif ($valor_glicemia >= 100 && $valor_glicemia <= 125) {
    //     $status = "Pré-diabetes";
    //     $mensagem = "Fique atento e consulte seu médico.";
    //     $classe_status = "pre-diabetes";
    // } else {
    //     $status = "Diabetes";
    //     $mensagem = "Procure orientação médica imediatamente.";
    //     $classe_status = "diabetes";
    // }

    // $tipo_medicao pode ser: "jejum", "pre_refeicao", "pos_refeicao"
// $valor é o número da medição

// if($tipo_medicao === "jejum" || $tipo_medicao === "pre_refeicao") {

//     if($valor_glicemia  < 70) {
//         $status  = "Preocupante";
//     } elseif($valor_glicemia  >= 70 && $valor_glicemia  <= 99) {
//         $status  = "Excelente";
//     } elseif($valor_glicemia  >= 100 && $valor_glicemia  <= 125) {
//         $status  = "Boa";
//     } else { // 126+
//         $status  = "Alerta máximo";
//     }

// } elseif($tipo_medicao === "pos_refeicao") {

//     if($valor_glicemia  < 140) {
//         $status  = "Excelente";
//     } elseif($valor_glicemia  >= 140 && $valor_glicemia  <= 179) {
//         $status  = "Boa";
//     } elseif($valor_glicemia  >= 180 && $valor_glicemia  <= 250) {
//         $status  = "Cuidado";
//     } else { // acima de 250
//         $status  = "Preocupante";
//     }

// } else {
//     $status  = "Tipo de registro inválido!";
// }

// echo $status ;

if ($tipo_medicao === "jejum" || $tipo_medicao === "pre_refeicao") { 

    if ($valor_glicemia < 70) {
        $status = "Preocupante";
        $mensagem = "Sua glicemia está muito baixa. Isso exige atenção imediata.";
        $classe_status = "preocupante";
    } elseif ($valor_glicemia >= 70 && $valor_glicemia <= 99) {
        $status = "Excelente";
        $pontuacao = 15;
        $mensagem = "Seu nível de glicose está ótimo!";
        $classe_status = "excelente";
    } elseif ($valor_glicemia >= 100 && $valor_glicemia <= 125) {
        $status = "Boa";
        $pontuacao = 10;
        $mensagem = "Sua glicemia está aceitável, mas fique atento.";
        $classe_status = "boa";
    } else { // 126+
        $status = "Alerta máximo";
        $mensagem = "Glicemia muito elevada. Procure orientação médica.";
        $classe_status = "alerta-maximo";
    }

} elseif ($tipo_medicao === "pos_refeicao") {

    if ($valor_glicemia < 140) {
        $status = "Excelente";
        $pontuacao = 15;
        $mensagem = "Seu nível pós-refeição está excelente.";
        $classe_status = "excelente";
    } elseif ($valor_glicemia >= 140 && $valor_glicemia <= 179) {
        $status = "Boa"; 
        $pontuacao = 10;
        $mensagem = "O nível está bom, mas é bom monitorar.";
        $classe_status = "boa";
    } elseif ($valor_glicemia >= 180 && $valor_glicemia <= 250) {
        $status = "Cuidado";
        $mensagem = "Glicemia elevada, atenção!";
        $classe_status = "cuidado";
    } else { // acima de 250
        $status = "Preocupante";
        $mensagem = "Nível muito alto! Procure ajuda médica.";
        $classe_status = "preocupante";
    }

} else {
    $status = "Erro";
    $mensagem = "Tipo de registro inválido.";
    $classe_status = "erro";
}

if ($status === "Excelente" || $status === "Boa") {
    $sql = "
        SELECT pontos FROM perfil_gamificado WHERE id_paciente = ? 
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_paciente); // "i" significa integer
    $stmt->execute();
    $result = $stmt->get_result();
    $medicao = $result->fetch_assoc();
    if ($medicao === null) { 
       $sql = "
        INSERT INTO perfil_gamificado (id_paciente, pontos) VALUES ($id_paciente, $pontuacao)
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $_SESSION['medido'] = true;
    } else {
        $pontosAtuais = $medicao ['pontos'];
        $pontuacaoNova = $pontosAtuais + $pontuacao; 

        
        $sql = "
        UPDATE perfil_gamificado SET pontos = $pontuacaoNova 
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $_SESSION['medido'] = true;
    }    
} 







} catch (Exception $e) {
    $erro = "Erro ao buscar dados: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análise da Glicemia - MedSuam</title>
    <link rel="stylesheet" href="./css/analise.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Análise da glicemia</h1>
        </header>
        
        <main class="main-content">
            <?php if (isset($erro)): ?>
                <div class="erro">
                    <?php echo $erro; ?>
                </div>
            <?php else: ?>
                <div class="valor-glicemia">
                    <span class="valor"><?php echo number_format($valor_glicemia, 0); ?></span>
                    <span class="unidade">mg/dL</span>
                </div>
                
                <div class="separador"></div>
                
                <div class="resultado <?php echo $classe_status; ?>">
                    <div class="status"><?php echo $status; ?></div>
                    <div class="mensagem"><?php echo $mensagem; ?></div>
                </div>
                
                <div class="info-mediacao">
                    <p>Medição: <?php echo $tipo_medicao; ?> | <?php echo $data_medicao; ?> às <?php echo $hora_medicao; ?></p>
                </div>
                
                <div class="acoes">
                    <a href="assisMedico.php" class="btn-continuar">Continuar</a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>