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
//発行量を確定
$mining_amount = 100;

//自分のwalletに上乗せ
$me = $pdo->query("select coin from wallet where id = '$my_id';");
$me_coin = $me->fetch(PDO::FETCH_ASSOC);
$me_coin_new = $me_coin["coin"] + $mining_amount;
$flag = $pdo->query("UPDATE `wallet` SET `coin` = '$me_coin_new' WHERE `id` = '$my_id';");
if ($flag){
    print('データの追加に成功しました<br>');
}else{
    print('データの追加に失敗しました<br>');
}

//相手のwalletに上乗せ
$mining = $pdo->query("select coin from wallet where id = '$mining_id';");
$mining_coin = $mining->fetch(PDO::FETCH_ASSOC);
$mining_coin_new = $mining_coin["coin"] + $mining_amount;
$flag = $pdo->query("UPDATE `wallet` SET `coin` = '$mining_coin_new' WHERE `id` = '$mining_id';");
if ($flag){
    print('データの追加に成功しました<br>');
}else{
    print('データの追加に失敗しました<br>');
}

//ユーザー間の距離を縮める

