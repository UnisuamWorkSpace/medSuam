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
    
    
    // Validar dados
    if (!empty($valor_glicemia) && !empty($tipo_medicao) && !empty($data_medicao) && !empty($hora_medicao)) {
        try {
            $sql = "INSERT INTO medicoes_glicemia (id_paciente, valor_glicemia, tipo_medicao, data_medicao, hora_medicao, observacoes) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("idssss", $id_paciente, $valor_glicemia, $tipo_medicao, $data_medicao, $hora_medicao, $observacoes);
            $stmt->execute();
            
            // Redirecionar para a página de análise após salvar
            header('Location: analiseGlicemia.php');
            exit;
            
        } catch (Exception $e) {
            $_SESSION['mensagem_erro'] = "Erro ao registrar medição: " . $e->getMessage();
        }
    } else {
        $_SESSION['mensagem_erro'] = "Por favor, preencha todos os campos obrigatórios.";
    }
 }   
    // Redirecionar para evitar reenvio do formulário
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