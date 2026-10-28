<?php
require_once __DIR__ . '/conn.php';
try {
  $sql = "SELECT * FROM evento";
  //$stmst = $conn->exec($sql);
  $stmst = $conn->query($sql);

  if ($stmst->rowCount() > 0) {
    echo "<table><tr><th>ID</th><th>Título</th><th>Local</th></tr>";
    // Output data of each row
    while($row = $stmst->fetch()) {
      echo "<tr>";
      echo "<td>" . $row['id'] . "</td>";
      echo "<td>" . $row['titulo_evento'] . "</td>";
      echo "<td>" . $row['data_evento'] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
    unset($stmst);
  } else {
    echo "alert('Nenhum registro de eventos foi encontrado!')";
  }

  echo $sql; //teste
} catch(PDOException $e) {
    echo "alert('Não foi possível consultar os eventos!')";
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>