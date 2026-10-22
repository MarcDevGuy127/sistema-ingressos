<?php

require_once __DIR__ . '/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Coletando os dados do formulário
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validando o nome
    if ($nome === '') {
        echo "<script>
            alert('Informe um nome válido.');
            window.history.back();
        </script>";
        exit;
    }

    // Validando o e-mail
    if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo "<script>
            alert('O e-mail informado é inválido.');
            window.history.back();
        </script>";
        exit;
    }

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO cliente (nome, email) VALUES (?, ?)"
        );

        $stmt->execute([$nome, $email]);

        echo "<script>
            alert('Cadastro realizado com sucesso!');
            window.location.href = '../index.html';
        </script>";
        exit;

    } catch (PDOException $e) {
        error_log($e->getMessage());

        echo "<script>
            alert('Não foi possível realizar o cadastro.');
            window.history.back();
        </script>";
        exit;
    }
}
?>