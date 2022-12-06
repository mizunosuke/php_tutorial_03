<?php
require("../functions/connect_db.php");

session_start();

//送信ボタンを押して、内容が入っていることを確認
if(!empty($_POST)) {
    //名前が空欄ではないか
    if($_POST["name"]==="") {
        $error["name"] = "名前を入力してください";
    } 

    //メールアドレスのバリデーション
    if($_POST["email"]==="") {
        $error["email"] = "メールアドレスを入力してください";
    } elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
        $error["email"] = "メールアドレスの形式が正しくありません";
    }

    //パスワードのバリデーション
    if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}$/',$_POST["pass"])) {
        $error[] = "パスワードは大文字、小文字、数字を含む8文字以上で設定してください";
    } else if($_POST["pass"] === "") {
        $error["pass"] = "パスワードを設定してください";
    }

    //メールアドレスの重複を確認
    if(!isset($error)) {
        //userテーブルのemailカラムから$_POST["email"]の内容と一致する行数を取得してcnt変数に入れる
        $sql = 'SELECT COUNT(*) as cnt FROM user_table WHERE email=?';
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute(array($_POST["email"]));
        $result = $stmt -> fetch();
        if($result["cnt"] > 0) {
            $error["email"] = "このメールアドレスは既に使用されています";
        }
    }

    //エラーが全てなかった場合、登録内容確認ページに遷移
    if(!isset($error)) {
        session_regenerate_id(true);
        $_SESSION["auth"] = $_POST;
        header("Location:confirm.php");
        exit();
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <div class="form_container">
        <div><h1>Sing Up</h1></div>
        <form action="" method="POST">
            <div class="input_info">
                <label for="">
                    お名前
                    <input type="text" name="name">
                    <?php if (!empty($error["name"]) && $error['name'] === '名前を入力してください'): ?>
                        <p class="error">＊名前を入力してください</p>
                    <?php endif ?>
                </label>
            </div>
            <div class="input_info">
                <label for="">
                    メールアドレス
                    <input type="text" name="email">
                    <?php if (!empty($error["email"]) && $error['email'] === 'メールアドレスを入力してください'): ?>
                    <p class="error">＊メールアドレスを入力してください</p>
                    <?php elseif (!empty($error["email"]) && $error['email'] === 'このメールアドレスは既に使用されています'): ?>
                        <p class="error">＊このメールアドレスはすでに登録済みです</p>
                    <?php elseif (!empty($error["email"]) && $error['email'] === 'メールアドレスの形式が正しくありません'): ?>
                        <p class="error">メールアドレスの形式が正しくありません</p>
                    <?php endif ?>
                </label>
            </div>
            <div class="input_info">
                <label for="">
                    パスワード
                    <input type="password" name="pass">
                    <?php if (!empty($error["pass"]) && $error['pass'] === 'パスワードを設定してください'): ?>
                        <p class="error">＊パスワードを入力してください</p>
                    <?php elseif (!empty($error["pass"]) && $error['pass'] === 'パスワードは大文字、小文字、数字を含む8文字以上で設定してください'): ?>
                        <p class="error">パスワードは大文字、小文字、数字を含む8文字以上で設定してください</p>
                    <?php endif ?>
                </label>
            </div>
            <div class="submit-btn">
                <input type="submit" value="登録内容を確認する">
            </div>
        </form>
    </div>
</body>
</html>