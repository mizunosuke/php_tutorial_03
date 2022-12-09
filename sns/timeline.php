<?php
require("../functions/connect_db.php");
session_start();

if(!empty($_SESSION["id"])) {
    try {
        //全POSTデータを取得
        $sql = 'SELECT * FROM postdata_table';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
    
        $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // echo "<pre>";
        // var_dump($record);
        // echo "</pre>";

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
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
        <h1>タイムライン</h1>
        <?php foreach($record as $data) :?>
                <?php
                    // var_dump($data);
                    //postdataのuseridをもとにmypageへのリンク取得
                    $sql02 = 'SELECT nickname FROM mypage_table WHERE userid=:userid';
                    $stmt02 = $pdo->prepare($sql02);
                    $stmt02->bindValue(":userid",$data["userid"]);
                    $stmt02->execute();
                    $nickname = $stmt02->fetch(PDO::FETCH_ASSOC);
                    // var_dump($nickname);
                ?>
                <div>
                    <div>
                        <h2><a href="../userpage.php?id=<?=$data["userid"]?>">ニックネーム : <?=$nickname["nickname"]?></a></h2>
                    </div>
                    <img src=<?=$data["image"]?> alt="">
                    <div>
                        <p>魚種名 : <?=$data["fishname"]?></p>
                        <p>サイズ : <?=$data["size"]?></p>
                        <p>タックル : <?=$data["tackle"]?></p>
                        <p>ルアー : <?=$data["lure"]?></p>
                        <p>釣行場所 : <?=$data["area"]?></p>
                        <p>天気 : <?=$data["fishname"]?></p>
                        <p>日時 : <?=$data["created_at"]?></p>
                        <p>コメント : <?=$data["comment"]?></p>
                    </div>
                </div>
        <?php endforeach;?>
    </div>
    <div>
        <a href="postpage.php">新規投稿</a>
        <a href="../home/home.php">ホーム画面へ</a>
    </div>
</body>
</html>