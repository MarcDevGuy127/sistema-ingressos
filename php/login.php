<?php

session_start();

require_once __DIR__ . '/app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Coletando os dados enviados pelo formulário
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validando o nome
    if ($nome === '') {
        echo "<script>
            alert('Informe seu nome de usuário.');
            window.history.back();
        </script>";
        exit;
    }

    // Validando o formato do e-mail
    if (
        $email === '' ||
        filter_var($email, FILTER_VALIDATE_EMAIL) === false
    ) {
        echo "<script>
            alert('Informe um e-mail válido.');
            window.history.back();
        </script>";
        exit;
    }

    try {

        // Buscando o usuário pelo nome e pelo e-mail
        $sql = "SELECT * FROM cliente WHERE nome = ? AND email = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $email]);

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificando se as credenciais correspondem
        if ($usuario) {

            // Criando a sessão do usuário
            session_regenerate_id(true);

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['logado'] = true;

            header('Location: ../pages/tela_principal.html');
            exit;

        } else {

            echo "<script>
                alert('Nome de usuário ou e-mail incorretos.');
                window.history.back();
            </script>";
            exit;
        }

    } catch (PDOException $e) {

        error_log($e->getMessage());

        echo "<script>
            alert('Ocorreu um erro ao tentar efetuar o login.');
            window.history.back();
        </script>";
        exit;
    }
}
?>