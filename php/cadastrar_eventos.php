<?php
require_once __DIR__ . '/conn.php';
try {
  $sql = "INSERT INTO evento (
    id_evento,
    titulo_evento,
    quantidade_ingressos,
    quantidade_disponivel,
    quantidade_vendida,
    capacidade_evento,
    data_evento)
  VALUES ('Atracao A', 45, 45, 0, 45, '2026-10-28')";
  $conn->exec($sql);
  echo "alert('O evento foi cadastrado!')";
} catch(PDOException $e) {
    echo "alert('Não foi possível cadastrar o evento!')";
    echo $sql . "<br>" . $e->getMessage();
}
?>