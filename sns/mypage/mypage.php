<?php
require("../../functions/connect_db.php");
session_start();
var_dump($_SESSION["auth"]); //-> name,email,pass(暗号化されてない)の情報がある


//mypage_tableからデータをとってくる
//セッション変数に値がある場合
if(!empty($_SESSION["id"])) {
    try {
        $id = $_SESSION["id"];

    } catch(PDOException $e) {
        echo $e->getMessage();
    }  
} else {
    header("Location:../../welcome.php");
}

//mypage_tableからデータを取得して表示
$sql02 = 'SELECT COUNT(*) as cnt FROM mypage_table WHERE userid=:userid;';
$stmt02 = $pdo->prepare($sql02);
$stmt02->bindValue(":userid",$id);
$stmt02->execute();

$result = $stmt02->fetch();
if($result["cnt"] === 0) {
    //データがなかった場合は表示内容を変える
    header("Location:set_mypage.php");
    exit();
} else {
    //データがある場合はとってきたデータを表示
    $stmt03 = $pdo->prepare('SELECT * FROM mypage_table WHERE userid=:userid');
    $stmt03->bindValue(":userid",$id);
    $stmt03->execute();

    $prof_data = $stmt03->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($prof_data);

    //postdataがあるか確認してあれば表示
    $sql04 = 'SELECT COUNT(*) as cnt FROM postdata_table WHERE userid=:userid;';
    $stmt04 = $pdo->prepare($sql02);
    $stmt04->bindValue(":userid",$id);
    $stmt04->execute();

    $result02 = $stmt02->fetch();
    if($result02["cnt"] === 0) {
        exit();
    } else {
        $sql05 = 'SELECT * FROM postdata_table WHERE userid=:userid;';
        $stmt05 = $pdo->prepare($sql05);
        $stmt05->bindValue(":userid",$id);
        $stmt05->execute();

        $postdata = $stmt05->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        var_dump($postdata);
        echo "</pre>";
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYPAGE</title>
</head>
<body>
    <div class="mypage">
        <div>
            <h2>自分の投稿</h2>
            <?php foreach($postdata as $data) :?>
                <?php foreach($data as $key => $value) :?>
                    <div>
                        <p><?=$key?><?=$value?></p>
                    </div>
                <?php endforeach;?>
            <?php endforeach;?>
        </div>
        <a href="edit_mypage.php">mypageを編集する</a>
        <a href="../timeline.php">タイムラインへ</a>
    </div>
</body>
</html>