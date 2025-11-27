<?php
session_start();

$host = "localhost";
$dbname = "bd_medsuam";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

$idPaciente = $_SESSION['id_paciente'];

// =============================
// 1. BUSCAR PONTOS DO PACIENTE
// =============================
$stmt = $pdo->prepare("SELECT pontos FROM perfil_gamificado WHERE id_paciente = ?");
$stmt->execute([$idPaciente]);
$pontos = $stmt->fetchColumn();

// =============================
// 2. FUNÇÃO: obter último resgate
// =============================
function ultimaRetirada($pdo, $idPaciente, $cupom)
{
    $sql = "SELECT criado_em 
            FROM cupons 
            WHERE id_paciente = ? AND cupom = ?
            ORDER BY criado_em DESC
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idPaciente, $cupom]);

    return $stmt->fetchColumn() ?: "";
}

// =============================
// 3. Carregar datas reais do BD
// =============================
$ultimaRetirada5  = ultimaRetirada($pdo, $idPaciente, "5%");
$ultimaRetirada10 = ultimaRetirada($pdo, $idPaciente, "10%");
$ultimaRetirada15 = ultimaRetirada($pdo, $idPaciente, "15%");

// =============================
// CONFIGURAÇÃO DOS CUPONS
// =============================
$cupons = [
    5 => [
        'titulo' => 'Controle Saudável',
        'descricao' => '5 dias com glicemia estável',
        'pontos' => 330,
        'cooldown' => 30,
        'cooldown_text' => '1 vez por mês',
        'ultima_retirada' => $ultimaRetirada5
    ],
    10 => [
        'titulo' => 'Manutenção Excelente',
        'descricao' => '10 dias com glicemia estável',
        'pontos' => 660,
        'cooldown' => 60,
        'cooldown_text' => '1 vez a cada 2 meses',
        'ultima_retirada' => $ultimaRetirada10
    ],
    15 => [
        'titulo' => 'Resultado Perfeito',
        'descricao' => '15 dias com glicemia estável',
        'pontos' => 990,
        'cooldown' => 90,
        'cooldown_text' => '1 vez a cada 3 meses',
        'ultima_retirada' => $ultimaRetirada15
    ]
];

// =============================
// FUNÇÕES DE COOLDOWN
// =============================
function verificarCooldown($ultimaRetirada, $diasCooldown) {
    return true; // cooldown desativado por enquanto
}

function diasRestantesCooldown($ultimaRetirada, $diasCooldown) {
    return 0;
}

function formatarDataRetorno($ultimaRetirada, $diasCooldown) {
    return "";
}

// =============================
// 4. PROCESSAR RESGATE REAL
// =============================
$mensagemResgate = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cupom'])) {

    $cupomPercentual = intval($_POST['cupom']);
    $cupomTxt = $cupomPercentual . "%";

    switch ($cupomTxt) {
        case '5%':  $ponto = 330; break;
        case '10%': $ponto = 660; break;
        case '15%': $ponto = 990; break;
    }

    if (isset($cupons[$cupomPercentual])) {

        $cupom = $cupons[$cupomPercentual];

        // FIXED — user can redeem if they have MORE or EQUAL points
        $pontosCorretos = ($pontos >= $cupom['pontos']);
        $cooldownPassou = verificarCooldown($cupom['ultima_retirada'], $cupom['cooldown']);

        if ($pontosCorretos && $cooldownPassou) {

            // 4.1 Registrar cupom
            $stmt = $pdo->prepare("INSERT INTO cupons (id_paciente, cupom) VALUES (?, ?)");
            $stmt->execute([$idPaciente, $cupomTxt]);

            // 4.2 Subtrair pontos
            $pontuacaoNova = $pontos - $ponto;

            $stmt = $pdo->prepare("UPDATE perfil_gamificado SET pontos = ? WHERE id_paciente = ?");
            $stmt->execute([$pontuacaoNova, $idPaciente]);

            header("Location: recompensas.php?status=success");
            exit;

        } else {
            if (!$pontosCorretos) {
                $mensagemResgate = "error|Você precisa ter pelo menos {$cupom['pontos']} pontos.";
            }
        }
    }
}

list($tipoMensagem, $textoMensagem) = $mensagemResgate ? explode('|', $mensagemResgate, 2) : ['', ''];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Recompensas</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/recompensas.css">
</head>
<body>
    <div class="voltarLinkContainer">
        <a href="./assisMedico.php" class="linkVoltar"><i class="bi bi-caret-left-fill"></i> Voltar</a>
    </div>

    <div class="container">
        <header class="header">
            <h1>Cupons disponíveis para troca</h1>
            <div class="points-display">
                <span class="points-icon">🌟</span>
                <span class="points-value"><?php echo $pontos; ?> pts</span>
            </div>
        </header>

        <?php if ($mensagemResgate): ?>
            <div class="alert alert-<?php echo $tipoMensagem; ?>">
                <?php echo $textoMensagem; ?>
            </div>
        <?php endif; ?>

        <div class="coupons-grid">
            <?php foreach ($cupons as $percentual => $cupom): ?>
                <?php
                // FIXED — now allows >= instead of ==
                $pontosCorretos = ($pontos >= $cupom['pontos']);
                $cooldownPassou = verificarCooldown($cupom['ultima_retirada'], $cupom['cooldown']);
                $disponivel = $pontosCorretos && $cooldownPassou;
                ?>

                <div class="coupon-card <?php echo $disponivel ? 'available' : 'unavailable'; ?>">
                    <div class="coupon-header">
                        <h2 class="discount"><?php echo $percentual; ?>%</h2>
                        <span class="discount-text">desconto</span>
                    </div>
                    
                    <div class="coupon-body">
                        <h3 class="coupon-title"><?php echo $cupom['titulo']; ?></h3>
                        <p class="coupon-description"><?php echo $cupom['descricao']; ?></p>
                        
                        <div class="coupon-cost">
                            <span class="cost"><?php echo $cupom['pontos']; ?> pts</span>
                            <span class="cooldown"><?php echo $cupom['cooldown_text']; ?></span>
                        </div>
                        
                        <?php if ($disponivel): ?>
                            <form method="POST" class="redeem-form">
                                <input type="hidden" name="cupom" value="<?php echo $percentual; ?>">
                                <button type="submit" class="redeem-btn">
                                    Resgatar
                                </button>
                            </form>
                        <?php else: ?>
                            <div class="unavailable-message">
                                <?php if (!$pontosCorretos): ?>
                                    Faltam <?php echo ($cupom['pontos'] - $pontos); ?> pontos
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

        <div class="info-section">
            <h3>Como funciona?</h3>
            <p>Você pode resgatar qualquer cupom se tiver pontos suficientes. O valor do cupom será subtraído da sua pontuação.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.redeem-form');
            
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Tem certeza que deseja resgatar este cupom?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>
