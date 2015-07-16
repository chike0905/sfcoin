<?php
session_start();
// ログイン済みかどうかの変数チェックを行う
if (!isset($_SESSION["user_name"])) {

// 変数に値がセットされていない場合は不正な処理と判断し、ログイン画面へリダイレクトさせる
$no_login_url = "http://{$_SERVER["HTTP_HOST"]}/sfcoin/login.php";
header("Location: {$no_login_url}");
exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SFCOin</title>
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
      <a href="#" class="ui-btn-right">設定</a>
    </div>
    <div data-role="content">
      <div id="wallet">
        <div class="ui-bar ui-bar-d">
          <h3>
            採掘
          </h3>
        </div>
        <div class="ui-body ui-body-d">
          マイニングコード生成
        </div>
      </div>
      <div id="network">
        <div class="ui-bar ui-bar-d">
          <h3>
            ネットワーク
          </h3>
        </div>
        <div class="ui-body ui-body-d">
          ここにD3でビジュアル化したネットワークを表示
        </div>
      </div>
      <div id="miningmount">
        <div class="ui-bar ui-bar-d">
          <h3>
            友人とのマイニング量一覧
          </h3>
        </div>
        <div class="ui-body ui-body-d">
          友人とのマイニングした時の量を表示
        </div>
      </div>
    </div>
    <div data-role="footer">
      <div data-role="navbar">
      <ul>
        <li><a href="wallet.php" data-transition="none">財布</a></li>
        <li><a href="mining.php" class="ui-btn-active" data-transition="none">採掘</a></li>
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
