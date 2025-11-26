<?php
session_start();


// Verificar se o usuário está logado
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

// Configuração do banco de dados
$host = 'localhost';
$dbname = 'bd_medsuam';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Obter ID do usuário logado
$id = $_SESSION['id'];

// Verificar se o paciente tem permissão para usar o Assistente Médico
$sql_permissao = "SELECT * FROM assistente_medico WHERE id_paciente = ?";
$stmt_permissao = $pdo->prepare($sql_permissao);
$stmt_permissao->execute([$_SESSION['id']]);
$permissao = $stmt_permissao->fetch(PDO::FETCH_ASSOC);

 if ($permissao["status_monitoramento"]!="ativo") {
   // header("Location: sem_permissao.php");
   print_r($permissao);
    exit();
}

// Buscar a última medição do paciente
$sql_ultima = "SELECT * FROM medicoes_glicemia WHERE id_paciente = ? 
               ORDER BY data_medicao DESC, hora_medicao DESC LIMIT 1";
$stmt_ultima = $pdo->prepare($sql_ultima);
$stmt_ultima->execute([$_SESSION['id']]);
$ultima_medicao = $stmt_ultima->fetch(PDO::FETCH_ASSOC);
$data_ultimamedicao = $ultima_medicao["data_medicao"] ?? "";
$dia = date("d", strtotime($data_ultimamedicao));
$dia_atual = date("d");

// Buscar últimas 7 medições para o gráfico
$sql_grafico = "SELECT * FROM medicoes_glicemia WHERE id_paciente = ?
                ORDER BY data_medicao DESC, hora_medicao DESC LIMIT 7";
$stmt_grafico = $pdo->prepare($sql_grafico);
$stmt_grafico->execute([$_SESSION['id']]);
$medicoes_grafico = array_reverse($stmt_grafico->fetchAll(PDO::FETCH_ASSOC));


// Calcular meta atingida
$meta_atingida = false;
$texto_meta = "";
$tipo_ultima = ""; 

if ($ultima_medicao) {
    $tipo_ultima = $ultima_medicao['tipo_medicao'];
    $valor_ultima = $ultima_medicao['valor_glicemia'];

    switch($tipo_ultima) {
        case 'jejum':
            if ($valor_ultima >= 80 && $valor_ultima <= 130) {
                $meta_atingida = true;
                $texto_meta = "80-130 mg/dL (Jejum)";
            } else {
                $texto_meta = "Última medição foi {$valor_ultima} mg/dL (Jejum)";
            }
            break;

        case 'pre_refeicao':
            if ($valor_ultima >= 80 && $valor_ultima <= 130) {
                $meta_atingida = true;
                $texto_meta = "80-130 mg/dL (Pré-refeição)";
            } else {
                $texto_meta = "Última medição foi {$valor_ultima} mg/dL (Pré-refeição)";
            }
            break;

        case 'pos_refeicao':
            if ($valor_ultima <= 180) {
                $meta_atingida = true;
                $texto_meta = "≤ 180 mg/dL (Pós-refeição)";
            } else {
                $texto_meta = "Última medição foi {$valor_ultima} mg/dL (Pós-refeição)";
            }
            break;
    }
}

// Calcular próxima medição
$proxima_medicao = "8 horas";

if ($ultima_medicao) {
    switch($ultima_medicao['tipo_medicao']) {
        case 'jejum':
            $proxima_medicao = "8-12 horas";
            break;
        case 'pre_refeicao':
            $proxima_medicao = "2 horas";
            break;
        case 'pos_refeicao':
            $proxima_medicao = "1 hora";
            break;
    }
}

// Obter nome do paciente
$sql_paciente = "SELECT nome_paciente FROM paciente WHERE id_paciente = ?";
$stmt_paciente = $pdo->prepare($sql_paciente);
$stmt_paciente->execute([$_SESSION['id']]);
$paciente = $stmt_paciente->fetch(PDO::FETCH_ASSOC);

$nome_paciente = $paciente ? $paciente['nome_paciente'] : "Paciente";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedSuam - Assistente de Diabetes</title>
    <link rel="stylesheet" href="./css/assisMed.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav>
        <ul>
            <li><a class="paginaInicialLink" href="./recompensas.php">Resgatar cupons</a></li>
            <li><a class="paginaInicialLink" href="./userpage.php">Voltar para página Inicial</a></li>         
            <li><a class="paginaInicialLink" href="./meusCupons.php">Seus cupons</a></li>
        </ul>
    </nav>
    <div class="container">
        <header>
            <h1>MedSuam</h1>
            <p class="subtitle">Assistente de Diabetes</p>
        </header>

        <main>

            <div class="card">
                <h2>Última glicemia:</h2>
                <div class="glicemia-value">
                    <?php echo $ultima_medicao ? $ultima_medicao['valor_glicemia'] : '--'; ?> mg/dL
                </div>
            </div>

            <div class="card <?php echo $meta_atingida ? 'meta-atingida' : 'meta-fora'; ?>">
                <?php if ($meta_atingida): ?>
                    <div class="meta-icon">✓</div>
                    <h3>Meta atingida!</h3>
                <?php else: ?>
                    <div class="meta-icon alert">!</div>
                    <h3>Fora da meta</h3>
                <?php endif; ?>
                <p><?php echo $texto_meta ?: "Nenhuma medição registrada"; ?></p>
            </div>

            <div class="card">
                <h3>Próxima medida em:</h3>
                <p class="next-measurement"><?php echo $proxima_medicao; ?></p>
            </div>

            <div class="card chart-card">
                <h3>Histórico de Glicemia</h3>
                <canvas id="glicemiaChart"></canvas>
            </div>

            <!-- <button class="add-button" onclick="window.location.href='registrarGlicemia.php'">
                + Adicionar Glicemia
            </button> -->
            
            <?php if ($dia != $dia_atual): ?>
                <button class="add-button" onclick="window.location.href='registrarGlicemia.php'">
                + Adicionar Glicemia
                </button>
            <?php else: ?>
                <p class="centralized">Sua glicemia já foi cadastrada hoje!</p>
            <?php endif; ?>

        </main>
    </div>

<script>
const medicoes = <?php echo json_encode($medicoes_grafico); ?>;

const labels = medicoes.map(m => {
    const dt = new Date(m.data_medicao + "T" + m.hora_medicao);
    return dt.toLocaleDateString("pt-BR");
});

const valores = medicoes.map(m => m.valor_glicemia);

new Chart(document.getElementById("glicemiaChart"), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: "Glicemia",
            data: valores,
            borderColor: "#4ECDC4",
            backgroundColor: "rgba(78,205,196,.15)",
            borderWidth: 3,
            fill: true,
            tension: .4
        }]
    },
    options: { responsive: true }
});
</script>

</body>
</html>
