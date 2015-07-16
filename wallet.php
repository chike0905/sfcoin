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
      <?php
        echo '<h2>ようこそ'.$_SESSION["user_name"].'さん</h2>';
      ?>
      <div id="wallet">
        <div class="ui-bar ui-bar-d">
          <h3>
            現在の保有SFCoin
          </h3>
        </div>
        <div class="ui-body ui-body-d">
          <?php
            $usr = $pdo->query('select * from user;');
            foreach($usr as $user){
              if($user['name'] == $_SESSION["user_name"]){
                $usr_id = $user['id'];
              }
            }
            $coins = $pdo->query('select * from wallet');
            foreach($coins as $coin){
              if($coin['id'] == $usr_id){
                $coin_m = $coin['coin'];
              }
            }
            echo '<span id="coinmount">'. $coin_m .'</span> SFCoin';
          ?>
        </div>
      </div>
      <div id="history">
        <div class="ui-bar ui-bar-d">
          <h3>
            使用履歴
          </h3>
        </div>
        <div class="ui-body ui-body-d">
          <ul data-role="listview">
            <li><a href="#">2015/6/17 gossy -2000 SFCoin</a></li>
            <li><a href="#">2015/6/17 gossy -2000 SFCoin</a></li>
            <li><a href="#">2015/6/17 gossy -2000 SFCoin</a></li>
            <li><a href="#">2015/6/17 gossy -2000 SFCoin</a></li>
          </ul>
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
