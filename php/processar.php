<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_usuario = $_POST['nome_usuario'];
    $email_usuario = $_POST['email_usuario'];

    if ($nome_usuario !== $nome_usuario) {
        echo "<h1 id='erro'>Os nomes não coincidem. Tente novamente.</h1>";
        echo "<a href='../index.html'>Retorne para a página principal</a>";
        exit;
    }

    if (empty($email_usuario) || !filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
        echo "<h1 id='erro'>Erro: informe um E-mail válido.</h1>";
        echo "<a href='../index.html'>Retorne para a página principal</a>";
        exit;
    }

    echo "<h1 id='correto'>Login bem-sucedido!</h1>";
    echo '<textarea rows="16" cols="40">';
    echo "Nome: " . htmlspecialchars($nome_usuario) . "\n";
    echo "E-mail: " . htmlspecialchars($email_usuario) . "\n";
    echo "</textarea>";
}
?>