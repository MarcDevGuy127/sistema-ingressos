
<?php

require_once __DIR__ . '/app.php'; // refenciando arquivo config


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome_usuario = trim($_POST['nome'] ?? '');
    $email_usuario = trim($_POST['email'] ?? '');


    try {
        $consulta = $pdo->prepare(
            "INSERT INTO cliente (nome, email)
             VALUES (:nome, :email)"
        );

        $consulta->bindValue(':nome', $nome_usuario);
        $consulta->bindValue(':email', $email_usuario);

        $consulta->execute();

        echo "<h1>Cadastro realizado com sucesso!</h1>";
        header("Location: ../index.html");
        exit;
    } catch (PDOException $e) {
        // Registre os detalhes no log do servidor
        error_log($e->getMessage());

        echo "<h1>Erro ao cadastrar!</h1>";
    }
}
?>
