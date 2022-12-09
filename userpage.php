<?php
require("./functions/connect_db.php");
session_start();

// var_dump($_SESSION["id"]);
if(isset($_GET["id"])) { $urlid = $_GET["id"]; }

$intUrlId = intval($urlid);
//表示中のuserのuseridを取得
// var_dump($intUrlId);

if(!empty($_SESSION["id"])) {
    try {
        //userのmyoage情報を取得
        $sql = 'SELECT * FROM mypage_table WHERE userid=:userid;';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":userid",$intUrlId);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        var_dump($result);
        echo "</pre>";

        //userのpostdataを取得
        $sql02 = 'SELECT * FROM postdata_table WHERE userid=:userid;';
        $stmt02 = $pdo->prepare($sql02);
        $stmt02->bindValue(":userid",$intUrlId);
        $stmt02->execute();

        $result02 = $stmt02->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        var_dump($result02);
        echo "</pre>";

        //relationsテーブルからidを取ってきて一致するか確認
        $sql03 = 'SELECT * FROM relations WHERE follow_id=:follow_id AND followed_id=:followed_id;';
        $stmt03 = $pdo->prepare($sql03);
        $stmt03->bindValue(":follow_id",$_SESSION["id"]);
        $stmt03->bindValue(":followed_id",$intUrlId);
        $stmt03->execute();
        //followidがログイン中のユーザーと一致　かつ　followedidが表示中のユーザと一致した場合
        $result03 = $stmt03->fetch(PDO::FETCH_ASSOC);
        var_dump($result03);
        // if($result03) {
        //     //表示するのはフォロー中
        // } else {
        //     //表示するのはフォロー
        //     echo "フォローしてないよ！";
        // }

    } catch(PDOException $e) {
        echo $e->getMessage();
        session_destroy();
        header("Location:welcome.php");
    }
    //フォローボタンが押されたらfollowidにログインユーザのIDを、followedidに表示ページのユーザーIDを入れる
    if(!empty($_POST["follow"])) {
        try {
            $sql04 = "INSERT INTO `relations` (`follow_id,followed_id`) VALUES(:follow_id,:followed_id)";
            $stmt04 = $pdo->prepare($sql04);
            $stmt04->bindValue(":follow_id",$_SESSION["id"]);
            $stmt04->bindValue(":followed_id",$intUrlId);
            $stmt04->execute();
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーページ</title>
</head>
<body>
    <div>
        <div>
            <h1>ユーザープロフィール</h1>
            <?php foreach($result as $userdata):?>
                <h3><?=$userdata["nickname"]?></h3>
                    <form action="" method="POST">
                        <?php if ($result03): ?>
                        <button type="button" name="follow">フォロー中</button>
                        <?php else: ?>
                        <button type="button" name="follow">フォロー</button>
                        <input type="hidden" name="follow">
                        <?php endif; ?>
                    </form>
                <div>
                    <p>プロフィール写真</p>
                    <img src=<?=$userdata["image"]?> alt="">
                </div>
                <p>よく釣りをするエリア : <?=$userdata["area"]?></p>
                <p>自己紹介 : <?=$userdata["intro"]?></p>
            <?php endforeach ;?>
        </div>

        <div>
        <h1>投稿一覧</h1>
            <?php foreach($result02 as $post):?>
                <img src=<?=$post["image"]?> alt="">
                    <div>
                        <p>魚種名 : <?=$post["fishname"]?></p>
                        <p>サイズ : <?=$post["size"]?></p>
                        <p>タックル : <?=$post["tackle"]?></p>
                        <p>ルアー : <?=$post["lure"]?></p>
                        <p>釣行場所 : <?=$post["area"]?></p>
                        <p>天気 : <?=$post["fishname"]?></p>
                        <p>日時 : <?=$post["created_at"]?></p>
                        <p>コメント : <?=$post["comment"]?></p>
                    </div>
            <?php endforeach ;?>
        </div>
    </div>
</body>
</html>