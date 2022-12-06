<?php
require("../../functions/connect_db.php");
//セッションでuseridを取得する
session_start();

// var_dump($_POST);
// exit();
if(!empty($_SESSION)) {
    try {
        //sessionのidを利用してmypage_tableからデータを取得
        $sql = 'SELECT COUNT(*) as cnt FROM mypage_table WHERE userid=:userid;';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":userid",$_SESSION["id"]);
        $stmt->execute();

        $result = $stmt->fetch();
        if($result["cnt"] === 0) {
            //データがなかった場合は初期設定画面へ遷移
            header("Location:set_mypage.php");
            exit();
        } else {
            //データがある場合は更新処理へ
            //mypage_tableから全データを取得
            $sql02 = 'SELECT * FROM mypage_table WHERE userid=:userid;';
            $stmt02 = $pdo->prepare($sql02);
            $stmt02->bindValue(":userid",$_SESSION["id"]);
            $stmt02->execute();

            $record = $stmt02->fetch(PDO::FETCH_ASSOC);
            var_dump($record);

            //更新処理

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

            $sql03 = 'UPDATE mypage_table SET nickname=:nickname, area=:area, intro=:intro, image=:image WHERE userid=:userid;';
            $stmt03 = $pdo->prepare($sql03);
            $stmt03->bindValue(":nickname",$_POST["nickname"]);
            $stmt03->bindValue(":area",$_POST["area"]);
            $stmt03->bindValue(":intro",$_POST["comment"]);
            $stmt03->bindValue(":image",$up_file);
            $stmt03->bindValue(":userid",$_SESSION["id"]);

            $stmt03->execute();
            header("Location:mypage.php");
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    session_destroy();
    header("Location:../../welcome.php");
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
    <div class="edit_my_container">
        <h1>マイページ編集画面</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <img src=<?=$record["image"]?> alt="">
                <label for="">
                    写真を選択
                    <input type="file" name="filename">
                </label>
            </div>

            <div>
                <label for="">
                    ニックネーム
                    <input type="text" name="nickname" value=<?=$record["nickname"]?>>
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
                    <textarea name="comment" id="" cols="30" rows="10"><?=$record["intro"]?></textarea>
                </label>
            </div>
            <div>
                <input type="submit" name="check">
            </div>
        </form>
    </div>
</body>
</html>