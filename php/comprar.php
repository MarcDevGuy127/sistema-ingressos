
<?php

session_start();
require_once __DIR__ . '/app.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido.']);
    exit;
}

if (empty($_SESSION['id_cliente'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Faça login para comprar.']);
    exit;
}

$dados = json_decode(file_get_contents('php://input'), true);

$id_evento = filter_var(
    $dados['id_evento'] ?? null,
    FILTER_VALIDATE_INT
);

$id_cliente = (int) $_SESSION['id_cliente'];

if (!$id_evento || $id_evento < 1) {
    http_response_code(400);
    echo json_encode(['erro' => 'Evento inválido.']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Busca e bloqueia um ingresso disponível.
    $consulta = $pdo->prepare(
        "SELECT id_ingresso
         FROM ingresso
         WHERE id_evento = :id_evento
           AND status_ingresso = FALSE
           AND id_cliente IS NULL
         ORDER BY id_ingresso
         LIMIT 1
         FOR UPDATE"
    );

    $consulta->execute([':id_evento' => $id_evento]);
    $id = $consulta->fetchColumn();

    if (!$id) {
        $pdo->rollBack();

        http_response_code(409);
        echo json_encode([
            'erro' => 'Não há ingressos disponíveis para este evento.'
        ]);
        exit;
    }

    // Busca o nome do cliente autenticado.
    $consulta = $pdo->prepare(
        "SELECT nome
         FROM cliente
         WHERE id_cliente = :id_cliente"
    );

    $consulta->execute([':id_cliente' => $id_cliente]);
    $nome_cliente = $consulta->fetchColumn();

    if ($nome_cliente === false) {
        $pdo->rollBack();

        http_response_code(404);
        echo json_encode(['erro' => 'Cliente não encontrado.']);
        exit;
    }

    // Marca o ingresso como vendido.
    $consulta = $pdo->prepare(
        "UPDATE ingresso
         SET id_cliente = :id_cliente,
             nome_cliente = :nome_cliente,
             status_ingresso = TRUE
         WHERE id_ingresso = :id_ingresso"
    );

    $consulta->execute([
        ':id_cliente' => $id_cliente,
        ':nome_cliente' => $nome_cliente,
        ':id_ingresso' => $id
    ]);

    // Atualiza a quantidade disponível e vendida do evento.
    $consulta = $pdo->prepare(
        "UPDATE evento
         SET quantidade_disponivel = quantidade_disponivel - 1,
             quantidade_vendida = quantidade_vendida + 1
         WHERE id_evento = :id_evento
           AND quantidade_disponivel > 0"
    );

    $consulta->execute([':id_evento' => $id_evento]);

    if ($consulta->rowCount() !== 1) {
        throw new RuntimeException(
            'Não há quantidade disponível para este evento.'
        );
    }

    $pdo->commit();

    echo json_encode([
        'id_ingresso' => (int) $id,
        'nome_cliente' => $nome_cliente
    ]);

} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'erro' => 'Não foi possível concluir a compra.'
    ]);
}
