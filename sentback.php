<?php
//mySQL接続
try {
  $pdo = new PDO('mysql:host=localhost;dbname=sfcoin_test;charset=utf8', 'root', 'root', array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
  exit('データベース接続失敗。' . $e->getMessage());
}

$sent_mount = 300;//送金金額
$to_user = "root";//送る相手

//送金元のid取得
$usr = $pdo->query('select * from user;');
foreach($usr as $user){
  if($user['name'] == 'chike'/*$_SESSION["user_name"]*/){
    $from_id = $user['id'];
  }
}
//送金先のid取得
$usr = $pdo->query('select * from user;');
foreach($usr as $user){
  if($user['name'] == $to_user){
    $to_id = $user['id'];
  }
}
//送金元の財布から送金金額引き落とし
$from = $pdo->query("select coin from wallet where id = '$from_id';");
$from_coin = $from->fetch(PDO::FETCH_ASSOC);
$from_coin_new = $from_coin["coin"] - $sent_mount;
echo $from_coin["coin"];
$flag = $pdo->query("UPDATE `wallet` SET `coin` = '$from_coin_new' WHERE `id` = '$from_id';");
if ($flag){
    print('データの追加に成功しました<br>');
}else{
    print('データの追加に失敗しました<br>');
}

//送金先の財布に送金金額入金
$to = $pdo->query("select coin from wallet where id = '$to_id';");
$to_coin = $to->fetch(PDO::FETCH_ASSOC);
$to_coin_new = $to_coin["coin"] + $sent_mount;
echo $to_coin["coin"];
$flag = $pdo->query("UPDATE `wallet` SET `coin` = '$to_coin_new' WHERE `id` = '$to_id';");
if ($flag){
      print('データの追加に成功しました<br>');
}else{
      print('データの追加に失敗しました<br>');
}



//取引記録の記録
$date = date('Ymd');
$flag = $pdo->query("insert into sent (to_id,from_id,sent,date) value ('$to_id','$from_id','$sent_mount','$date')");
if ($flag){
  print('データの追加に成功しました<br>');
}else{
  print('データの追加に失敗しました<br>');
}

