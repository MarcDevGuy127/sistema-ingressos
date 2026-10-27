<?php
require_once __DIR__ . '/app.php'; // refenciando arquivo config

// validando dados filtrados
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

// se id, nome ou email forem diferentes, os dados são inválidos.
if (!$id || !$nome || !$email) {
    echo "<script>
        alert('Dados inválidos.');
        window.location.href = '../php/editar_info.php?id=$id';
    </script>";
    exit;
}

try {

    // query para verficar se já existe usuário com o mesmo e-mail informado
    $verifica = $pdo->prepare(
        "SELECT id FROM cliente WHERE email = :email AND id != :id"
    );
    $verifica->bindValue(':email', $email);
    $verifica->bindValue(':id', $id, PDO::PARAM_INT);
    $verifica->execute();

    if ($verifica->rowCount() > 0) {
        echo "<script>
            alert('Este e-mail já está em uso por outro usuário.');
            window.location.href = '../php/editar_info.php?id=$id';
        </script>";
        exit;
    }

    // query para executar atualização de dados
    $stmt = $pdo->prepare(
        "UPDATE cliente 
         SET nome = :nome, email = :email 
         WHERE id = :id"
    );

    // coletando valores alterados
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':email', $email);
    
    // executando atualização dos dados
    $stmt->execute();

    // mensagem para informar que os dados foram atualizados
    echo "<script>
        alert('Dados atualizados com sucesso!');
        window.location.href = '../pages/tela_inicial.html';
    </script>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>