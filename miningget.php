<?php
/* 相手のユーザー名をGETで受け取る
 * 距離計算を行い、発行量を確定
 * 相手と自分のwalletに発行数上乗せ
 * ユーザー間の距離を縮めて入力
 */
$mininguser = $_GET['name'];

//mySQL接続
try {
  $pdo = new PDO('mysql:host=localhost;dbname=sfcoin_test;charset=utf8', 'root', 'root', array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
  exit('データベース接続失敗。' . $e->getMessage());
}
//自分と相手のidを取得
$usr = $pdo->query('select * from user;');
foreach($usr as $user){
  if($user["name"] === "chike"/*$_SESSION["user_name"]*/){
    $my_id = $user["id"];
  } else if($user["name"] === $mininguser){
    $mining_id = $user["id"];
  }
}
var_dump($my_id);
var_dump($mining_id);
