<?php
session_start();
include 'dbMedsuam.php';
    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['finalizarConsulta'])) {
        $consulta = mysqli_real_escape_string($conn, $_POST['consulta']);
        $sql = "UPDATE consulta SET status = 'Finalizado' WHERE id_consulta = $consulta ";
        mysqli_query($conn, $sql);
        header('location: medicopage.php');
    }