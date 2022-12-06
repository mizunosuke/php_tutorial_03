<?php
require("../functions/connect_db.php");
session_start();

if(!empty($_SESSION["id"])) {
    $sql = 'SELECT * FROM postdata_table';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<pre>";
    var_dump($record);
    echo "</pre>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <a href="postpage.php">新規投稿</a>
        <a href="../home/home.php">ホーム画面へ</a>
    </div>
</body>
</html>