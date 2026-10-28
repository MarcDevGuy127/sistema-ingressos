<?php
require_once __DIR__ . '/conn.php';
try {
  $sql = "INSERT INTO cliente (nome, email)
  VALUES ('Marcelo', 'marcelo@email.com')";
  $conn->exec($sql);
  echo "alert('O usuário foi cadastrado!')";
} catch(PDOException $e) {
    echo "alert('Não foi possível cadastrar o usuário!')";
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>