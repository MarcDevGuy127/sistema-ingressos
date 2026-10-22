<?php

// defining consts for reference database info
define('DB_HOST', 'localhost');
define('DB_NAME', 'sistema_ingressos');
define('DB_USER', 'postgres');
define('DB_PASS', 'Passw0rd');

// trying connection with database, using the defined consts
try {
    $pdo = new PDO("pgsql:host=".DB_HOST.";port=5432;dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}
?>