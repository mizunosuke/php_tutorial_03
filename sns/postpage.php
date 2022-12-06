<?php
require("../functions/connect_db.php");
session_start();

//session保持の確認
// var_dump($_SESSION["id"]);

if(!empty($_SESSION["id"])) {

    //登録ボタンが押されたら
    if(!empty($_POST["submit"])) {
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
            $up_file = "../postimg/". date("Ymd_His.") . mt_rand(1000,9999) . ".$ext";
            //move_uploaded_fileで絶対パス($tmp_file)から相対パス($up_file)に保存先を変更
            $up_ok = move_uploaded_file($tmp_file, $up_file);
        }
    }
    //postされた内容をdbに保存
    $sql = "INSERT INTO `postdata_table` (`fishname`, `size`, `tackle`, `lure`, `weather`, `comment`, `userid`, `created_at`, `updated_at`, `image`, `area`) VALUES (:fishname, :size, :tackle, :lure, :weather, :comment, :userid, now(), NULL, :filename, :area);";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":fishname",$_POST["fish_name"]);
    $stmt->bindValue(":size",$_POST["size"]);
    $stmt->bindValue(":tackle",$_POST["tackle"]);
    $stmt->bindValue(":lure",$_POST["lure"]);
    $stmt->bindValue(":weather",$_POST["weather"]);
    $stmt->bindValue(":comment",$_POST["comment"]);
    $stmt->bindValue(":userid",$_SESSION["id"]);
    $stmt->bindValue(":filename",$up_file);
    $stmt->bindValue(":area",$_POST["area"]);

    $stmt->execute();

    header("Location:timeline.php");
    }

} else {
    session_destroy();
    header("Location:../welcome.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSTPAGE</title>
</head>
<body>
    <div class="postform">
        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <img src="#" alt="">
                <label for="">
                    写真を選択
                    <input type="file" name="filename">
                </label>
            </div>

            <div>
                <label for="">
                    魚種
                    <input type="text" name="fish_name">
                </label>
            </div>

            <div>
                <label for="">
                    サイズ
                    <input type="text" name="size">
                </label>
            </div>

            <div>
                <label for="">
                    釣った場所
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
                    タックル
                    <input type="text" name="tackle">
                </label>
            </div>

            <div>
                <label for="">
                    ルアー
                    <input type="text" name="lure">
                </label>
            </div>

            <div>
                <label for="">
                    コメント
                    <textarea name="comment" id="" cols="30" rows="10"></textarea>
                </label>
            </div>

            <div>
                <label for="">
                    天気
                    <input type="text" name="weather">
                </label>
            </div>

            <div>
                <input type="submit" name="submit">
            </div>
        </form>
    </div>
</body>
</html>