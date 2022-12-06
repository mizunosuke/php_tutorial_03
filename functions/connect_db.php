<?php
//db接続
try {
    $pdo = new PDO('mysql:host=localhost;dbname=fish_sns03;charset=utf8mb4', 'root', '', array(PDO::ATTR_PERSISTENT => true));
} catch(PDOException $e) {
    echo "データベースに接続できませんでした:".$e -> get_massage();
}

?>