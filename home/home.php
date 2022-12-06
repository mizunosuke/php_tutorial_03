<?php

session_start();
echo "<pre>";
var_dump($_SESSION["auth"]);
var_dump($_SESSION["id"]);
echo "</pre>";

//セッション情報からuseridを取得


//ログアウトボタンが押されたら
if(!empty($_POST["logout"])) {
    //セッションの破棄
    session_destroy();
    //welcomeページへ移動
    header("Location:../welcome.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
</head>
<body>
    <div class="home_container">
        <div class="header_content">
            <h1>ヘッダーです</h1>
            <!-- <form action="../sns/mypage/mypage.php" method="POST">
                <div>
                    <input type="hidden" name="">
                    
                </div>
            </form> -->
            <a href="../sns/mypage/mypage.php">マイページへ</a>
        </div>

        <div class="main_content">
            <h1>メインコンテンツです</h1>
            <div class="left">
                クリッカブルマップの配置
            </div>
            <div class="right">
                <div class="timeline">
                    <!-- ここにpostdataの表示 -->
                    <a href="../sns/timeline.php">タイムラインを見る</a>
                    <a href="../sns/postpage.php">投稿する</a>
                </div>
            </div>
        </div>

        <div class="logout_container">
            <form action="" method="POST">
                <input type="submit" name="logout" value="ログアウト">
            </form>
        </div>
    </div>
</body>
</html>