<?php
session_start();
require_once 'dbMedsuam.php'; // Usar a mesma conexão do dbMedsuam.php

// Verificar se o usuário está logado (paciente)
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$id_paciente = $_SESSION['id'];

// Processar o formulário se for submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor_glicemia = $_POST['valor_glicemia'];
    $tipo_medicao = $_POST['tipo_medicao'];
    $data_medicao = $_POST['data_medicao'];
    $hora_medicao = $_POST['hora_medicao'];
    $observacoes = $_POST['observacoes'];
    
    
//     // Validar dados
//     if (!empty($valor_glicemia) && !empty($tipo_medicao) && !empty($data_medicao) && !empty($hora_medicao)) {
//         try {
//             $sql = "INSERT INTO medicoes_glicemia (id_paciente, valor_glicemia, tipo_medicao, data_medicao, hora_medicao, observacoes) 
//                     VALUES (?, ?, ?, ?, ?, ?)";
            
//             $stmt = $conn->prepare($sql);
//             $stmt->bind_param("idssss", $id_paciente, $valor_glicemia, $tipo_medicao, $data_medicao, $hora_medicao, $observacoes);
//             $stmt->execute();
            
//             // Redirecionar para a página de análise após salvar
//             header('Location: analiseGlicemia.php');
//             exit;
            
//         } catch (Exception $e) {
//             $_SESSION['mensagem_erro'] = "Erro ao registrar medição: " . $e->getMessage();
//         }
//     } else {
//         $_SESSION['mensagem_erro'] = "Por favor, preencha todos os campos obrigatórios.";
//     }
//  }   
//     // Redirecionar para evitar reenvio do formulário
// 
// 
// 
  // 1️⃣ Impedir mais de 1 registro por dia
    $sql_check = "SELECT id_medicao
              FROM medicoes_glicemia
              WHERE id_paciente = ?
              AND DATE(data_medicao) = ?
              LIMIT 1";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("is", $id_paciente, $data_hoje);
    $stmt_check->execute();
    $res_check = $stmt_check->get_result();

    if ($res_check->num_rows > 0) {
        $_SESSION['mensagem_erro'] = "Você já registrou sua glicemia hoje.";
        header("Location: analiseGlicemia.php");
        exit();
    }

    // 2️⃣ Calcular pontuação conforme regras enviadas
    $pontos = 0;

    if ($tipo_medicao === "jejum" || $tipo_medicao === "pre_refeicao") {

        if ($valor_glicemia >= 70 && $valor_glicemia <= 99) {
            $pontos = 15; // excelente
        } elseif ($valor_glicemia >= 100 && $valor_glicemia <= 125) {
            $pontos = 5; // boa
        }

    } elseif ($tipo_medicao === "pos_refeicao") {

        if ($valor_glicemia < 140) {
            $pontos = 15; // excelente
        } elseif ($valor_glicemia >= 140 && $valor_glicemia <= 179) {
            $pontos = 5; // boa
        }
    }

    // 3️⃣ Registrar medição
    if (!empty($valor_glicemia) && !empty($tipo_medicao) && !empty($data_medicao) && !empty($hora_medicao)) {
        try {

            $sql = "INSERT INTO medicoes_glicemia 
                    (id_paciente, valor_glicemia, tipo_medicao, data_medicao, hora_medicao, observacoes) 
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("idssss", $id_paciente, $valor_glicemia, $tipo_medicao, $data_medicao, $hora_medicao, $observacoes);
            $stmt->execute();

            // 4️⃣ Atualizar pontos do perfil gamificado
            $sql_up = "UPDATE perfil_gamificado SET pontos = pontos + ? WHERE id_paciente = ?";
            $stmt_up = $conn->prepare($sql_up);
            $stmt_up->bind_param("ii", $pontos, $id_paciente);
            $stmt_up->execute();

            // 5️⃣ Redirecionar após registrar
            header('Location: analiseGlicemia.php');
            exit;

        } catch (Exception $e) {
            $_SESSION['mensagem_erro'] = "Erro ao registrar medição: " . $e->getMessage();
        }
    } else {
        $_SESSION['mensagem_erro'] = "Por favor, preencha todos os campos obrigatórios.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Glicemia</title>
    <link rel="stylesheet" href="./css/registrar.css">
</head>
<body>
    <div class="container">
        <h1>Adicionar glicemia</h1>
        
        <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
            <div class="success-message">
                <?php echo $_SESSION['mensagem_sucesso']; ?>
                <?php unset($_SESSION['mensagem_sucesso']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['mensagem_erro'])): ?>
            <div class="error-message">
                <?php echo $_SESSION['mensagem_erro']; ?>
                <?php unset($_SESSION['mensagem_erro']); ?>
            </div>
        <?php endif; ?>
        
        <form id="glicemiaForm" method="POST" action="">
            <div class="form-group">
                <label for="valorGlicemia">Valor da Glicemia</label>
                <div class="input-group">
                    <input type="number" id="valorGlicemia" name="valor_glicemia" class="glicemia-input" 
                           placeholder="120" min="0" max="999" step="0.1" required>
                    <span class="mg-dl">mg/dL</span>
                </div>
            </div>
            
            <div class="form-group">
                <label>Tipo de Medição</label>
                <div class="tipo-medicao-group">
                    <label class="tipo-medicao-option">
                        <input type="radio" name="tipo_medicao" value="jejum" required>
                        <span>Jejum</span>
                    </label>
                    <label class="tipo-medicao-option">
                        <input type="radio" name="tipo_medicao" value="pre_refeicao">
                        <span>Pré-refeição</span>
                    </label>
                    <label class="tipo-medicao-option">
                        <input type="radio" name="tipo_medicao" value="pos_refeicao">
                        <span>Pós-refeição</span>
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="dataMedicao">Data e Hora</label>
                <div class="datetime-group">
                    <input type="date" id="dataMedicao" name="data_medicao" class="date-input" required>
                    <input type="time" id="horaMedicao" name="hora_medicao" class="time-input" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="observacoes">Observações (opcional)</label>
                <textarea id="observacoes" name="observacoes" class="glicemia-input" rows="3" 
                          placeholder="Adicione observações sobre a medição..."></textarea>
            </div>
            
            <button <a hrer="analiseGlicemia.php" type="submit" class="btn-salvar">Salvar</button>
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>