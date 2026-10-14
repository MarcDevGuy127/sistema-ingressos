<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_usuario = $_POST['nome_usuario'];
    $email_usuario = $_POST['email_usuario'];

    if ($nome_usuario !== $nome_usuario) {
        echo "<h1 id='erro'>Esse nome não está cadastrado. Tente novamente.</h1>";
        echo "<a href='../index.html'>Retornar para a página principal</a>";
        exit;
    }

    if (empty($email_usuario) || !filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
        echo "<h1 id='erro'>Esse e-mail não é válido.</h1>";
        echo "<a href='../index.html'>Retornar para a página principal</a>";
        exit;
    }

    echo "<h1>Olá, ".  htmlspecialchars($nome_usuario) . "!</h1>";
}
?>