<?php
require("../../functions/connect_db.php");
session_start();

var_dump($_SESSION);

//セッション変数の中身があれば新規登録の処理
if(!empty($_SESSION["id"])) {
    //登録ボタンが押された時
    if(!empty($_POST["check"])) {
    //-----ファイル処理関連-----
    //アップロードされたファイルを初期化
    $up_file  = "";
    //ファイルの状態を初期化
    $up_ok = false;

    //アップロードされたファイルを一時的な名前で保存
    $tmp_file = isset($_FILES["filename"]["tmp_name"]) ? $_FILES["filename"]["tmp_name"] : "";
    //元のファイル名で保存するように元ファイル名を取得
    $origin_file = isset($_FILES["filename"]["name"]) ? $_FILES["filename"]["name"] : "";


    //ファイルが存在かつアップロードされたものだった場合
    if($tmp_file !== "" && is_uploaded_file($tmp_file)){
        //拡張子を取り出し$extに代入
        $split = explode(".",$origin_file); 
        $ext = end($split);

        //拡張子があるかつ拡張子名がファイル名でない場合
        if($ext != "" && $ext != $origin_file){
            $up_file = "../../img/". date("Ymd_His.") . mt_rand(1000,9999) . ".$ext";
            //move_uploaded_fileで絶対パス($tmp_file)から相対パス($up_file)に保存先を変更
            $up_ok = move_uploaded_file($tmp_file, $up_file);
        }
    }
        
        //postされたデータをmypage_tableに保存
        $stmt = $pdo->prepare("INSERT INTO `mypage_table` (`nickname`, `intro`, `area`, `userid`, `image`) VALUES (:nickname, :intro, :area, :userid, :image);");
        $stmt->bindValue(":nickname",$_POST["nickname"]);
        $stmt->bindValue(":intro",$_POST["comment"]);
        $stmt->bindValue(":area",$_POST["area"]);
        $stmt->bindValue(":userid",$_SESSION["id"]);
        $stmt->bindValue(":image",$up_file);

        $stmt->execute();
        header("Location:mypage.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マイページ設定</title>
</head>
<body>
    <div>
        <h1>マイページ初期設定</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label for="">
                    写真を選択
                    <input type="file" name="filename">
                </label>
            </div>

            <div>
                <label for="">
                    ニックネーム
                    <input type="text" name="nickname">
                </label>
            </div>

            <div>
                <label for="">
                    よく釣りをするエリア
                    <select name="area" id="">
                        <option value="">選択してください</option>
                        <option value="広島湾">広島湾</option>
                        <option value="倉橋島">倉橋島</option>
                        <option value="音戸の瀬戸">音戸の瀬戸</option>
                        <option value="とびしま海道">とびしま海道</option>
                    </select>
                </label>
            </div>
            
            <div>
                <label for="">
                    自己紹介
                    <textarea name="comment" id="" cols="30" rows="10"></textarea>
                </label>
            </div>
            <div>
                <input type="submit" name="check">
            </div>
        </form>
    </div>
</body>
</html>