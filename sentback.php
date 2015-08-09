<?php
<?php
session_start();
// ログイン済みかどうかの変数チェックを行う
if (!isset($_SESSION["user_name"])) {

// 変数に値がセットされていない場合は不正な処理と判断し、ログイン画面へリダイレクトさせる
$no_login_url = "http://{$_SERVER["HTTP_HOST"]}/sfcoin/login.php";
header("Location: {$no_login_url}");
exit;
}
//mySQL接続
try {
  $pdo = new PDO('mysql:host=localhost;dbname=sfcoin_test;charset=utf8', 'root', 'root', array(PDO::ATTR_EMULATE_PREPARES => false));
} catch (PDOException $e) {
  exit('データベース接続失敗。' . $e->getMessage());
}

$sent_mount = $_POST["mount"];//送金金額
$to_user = $_POST["friend"];//送る相手

//送金元のid取得
$usr = $pdo->query('select * from user;');
foreach($usr as $user){
  if($user['name'] == $_SESSION["user_name"]){
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SFCoin</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet"
  href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
  <script type="text/javascript"
  src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
  <script type="text/javascript"
  src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
  <link rel="stylesheet" href="style/main.css" />
</head>
<body>
  <div data-role="page">
    <div data-role="header">
      <h1>SFCoin</h1>
    </div>
    <div data-role="content">
      <div id="wallet">
        <div class="ui-bar ui-bar-d">
          <h3>
            現在の保有SFCoin
          </h3>
        </div>
        <div class="ui-body ui-body-d">
        </div>
      </div>
    </div>
    <div data-role="footer">
      <div data-role="navbar">
      <ul>
        <li><a href="wallet.php" class="ui-btn-active" data-transition="none">財布</a></li>
        <li><a href="mining.php" data-transition="none">採掘</a></li>
        <li><a href="sent.php" data-transition="none">送金</a></li>
        <li><a href="config.php" data-transition="none">設定</a></li>
      </ul>
      </div>
      <p style="text-align:center;">
        Copyright 2015 SFCoin project
      </p>
    </div>
  </div>
</body>
</html>

