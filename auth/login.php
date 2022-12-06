<?php
require("../functions/connect_db.php");
//セッション開始
session_start();

//ログインボタンが押された場合
if(isset($_POST["login"])) {
    //POSTの中身が空でない場合
    if(!empty($_POST)) {
        try {
            //username,passwordが空じゃないか確認
            if($_POST["name"] === "" || $_POST["pass"] === "") {
                $error = "入力内容が不足しています";
            } else {
                //dbから名前が一致する行のpassを取得
                $sql = 'SELECT pass FROM user_table WHERE name= :name;';
                $stmt = $pdo -> prepare($sql);
                $stmt->bindValue(":name",$_POST["name"]);
                $stmt->execute();
                //$passに取得したpasswordを代入
                $pass = $stmt->fetch();
                var_dump($pass);

                //postされたpassとdbからとってきたpassが一致するか確認
                if(password_verify($_POST["pass"],$pass["pass"])) {
                    session_regenerate_id(true);

                    //認証成功後の処理
                    $sql02 = 'SELECT id FROM user_table WHERE name=:name AND pass=:pass;';
                    $stmt02 = $pdo -> prepare($sql02);
                    $stmt02->bindValue(":name",$_POST["name"]);
                    $stmt02->bindValue(":pass",$pass["pass"]);
                    $stmt02->execute();
                //$passに取得したpasswordを代入
                    $result = $stmt02->fetch();
                    $id = $result["id"];
                    //セッション変数にPOSTされたデータを保存
                    $_SESSION["auth"] = $_POST;
                    $_SESSION["id"] = $id;
                    header("Location:../home/home.php");
                    exit();
                }
            }
        } catch(PDOException $e) {
            echo "接続失敗".$e->getMessage();
            die();
        }
              
    } else {
        echo "error サーバー接続に失敗しました";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
</head>
<body>
    <div class="login_container">
        <div>
            <h1>Log In</h1>
        </div>
        <form action="" method="POST">
            <div>
                <label for="">
                    お名前
                    <input type="text" name="name">
                </label>
            </div>

            <div>
                <label for="">
                    パスワード
                    <input type="password" name="pass">
                </label>
            </div>
            <div>
                <input type="submit" value="login" name="login">
                <div><a href="register.php">新規登録画面へ</a></div>
            </div>
        </form>
    </div>
</body>
</html>