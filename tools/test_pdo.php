<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=propery_chain_back_end', 'root', '');
    echo "connected\n";
} catch (PDOException $e) {
    echo 'err:' . $e->getMessage() . PHP_EOL;
}
