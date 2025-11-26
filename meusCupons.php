<?php
session_start();
include "dbMedsuam.php";

// Get logged patient ID
$id_paciente = $_SESSION['id_paciente'];

// Fetch coupons from DB
$sql = "SELECT * FROM cupons WHERE id_paciente = '$id_paciente' ORDER BY criado_em DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seus Cupons</title>
  <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
          <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
  crossorigin="anonymous"
/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/meusCupons.css">
  
</head>

<body>
    <div class="voltarLinkContainer">
        <a href="./assisMedico.php" class="linkVoltar"><i class="bi bi-caret-left-fill"></i> Voltar</a>
    </div>
  <h1>Seus Cupons</h1>

  <?php if ($result->num_rows === 0): ?>
      <p class="empty">Você ainda não possui cupons.</p>

  <?php else: ?>
    <div class="coupon-container">

      <?php while ($row = $result->fetch_assoc()): ?>
        <?php
          $isUsed = $row['resgatado'] == 1;
        ?>

        <div class="coupon <?= $isUsed ? 'used' : '' ?>">
          <div class="coupon-code"><i class="fa-solid fa-ticket"></i> <?= $row['cupom'] ?></div>
          <!-- <div class="coupon-info">Pontos usados: <?= $row['pontos_usados'] ?></div> -->
          <div class="coupon-info">Criado em: <?= $row['criado_em'] ?></div>

          <?php if ($isUsed): ?>
            <div class="status used">Já resgatado</div>
          <?php else: ?>
            <div class="status active">Disponível</div>
          <?php endif; ?>
        </div>

      <?php endwhile; ?>

    </div>
  <?php endif; ?>

</body>
</html>
