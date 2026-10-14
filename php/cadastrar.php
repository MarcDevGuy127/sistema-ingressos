<?php

// importando arquivo de conexao
require_once 'app.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consulta = $pdo->prepare("INSERT INTO cliente(nome, email) VALUES (:nome, :email)");
    $consulta->bindParam(':nome', $nome_usuario);
    $consulta->bindParam(':email', $email_usuario);

    if ($consulta->execute()) {
        echo "<script>alert(O cadastro foi realizado com sucesso!);</script>";
    } else {
        echo "<script>alert(Erro ao cadastrar!);</script>";
    }
}
?>