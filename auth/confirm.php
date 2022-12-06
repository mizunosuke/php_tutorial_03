<?php
//dbの接続
require("../functions/connect_db.php");
session_start();


//セッション変数が空の場合register.phpへ返す
if(!isset($_SESSION["auth"])) {
    header("Location:register.php");
    exit();
}

//登録ボタンが押されたら情報をDBに保存
if(!empty($_POST["check"])) {
    //パスワード暗号化
    $password = password_hash($_SESSION["auth"]["pass"],PASSWORD_BCRYPT);

    //dbに保存
    $sql = "INSERT INTO user_table SET name=?, email=?, pass=?";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute(array(
        $_SESSION["auth"]["name"],
        $_SESSION["auth"]["email"],
        $password
    ));

    $sql02 = 'SELECT id FROM user_table WHERE name=:name AND email=:email;';
    $stmt02 = $pdo->prepare($sql02);
    $stmt02->bindValue(":name",$_SESSION["auth"]["name"]);
    $stmt02->bindValue(":email",$_SESSION["auth"]["email"]);
    $stmt02->execute();

    $result = $stmt02->fetch();
    $id = $result["id"];

    $_SESSION["id"] = $id;

    session_regenerate_id(true);
    header("Location:../home/home.php");
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録内容確認画面</title>
</head>
<body>
    <div class="confirm_container">
        <form action="" method="POST">
            <!-- 登録内容をPOSTで送るためにinputタグを配置 -->
            <input type="hidden" name="check" value="checked">
            <h1>登録内容確認</h1>
            <p>以下の内容で登録してよろしいですか?</p>
            <?php if (!empty($error) && $error === "error"): ?>
                <p class="error">＊会員登録に失敗しました。</p>
            <?php endif ?>
        
            <div>
                <p>お名前</p>
                <!-- <p>ここにPOSTで受け取った内容を入れる</p> -->
                <?=$_SESSION["auth"]["name"]?>
            </div>

            <div>
                <p>メールアドレス</p>
                <!-- <p>ここにPOSTで受け取った内容を入れる</p> -->
                <?=$_SESSION["auth"]["email"]?>
            </div>

            <div>
                <p>パスワード</p>
                <!-- <p>ここにPOSTで受け取った内容を入れる</p> -->
                <?=$_SESSION["auth"]["password"]?>
            </div>
            <div>
                <button type="submit">この内容で登録する</button>
            </div>
        </form>
    </div>
</body>
</html>