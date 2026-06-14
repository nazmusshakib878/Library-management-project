<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=library_management;charset=utf8', 'root', '');
    $stmt = $pdo->query('SHOW COLUMNS FROM books');
    $cols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cols, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
