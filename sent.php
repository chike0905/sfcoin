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
      <a href="#" class="ui-btn-right">設定</a>
    </div>
    <div data-role="content">
        <div class="ui-bar ui-bar-d">
          <h3>
            送金
          </h3>
        </div>
        <div class="ui-body ui-body-d">
        <div class="ui-field-contain">
          <label for="season">相手を選択</label>
          <select name="firends" id="friends" data-native-menu="false">
          <?php
            $usr = $pdo->query('select * from user;');
            foreach($usr as $user){
              if($user['name'] == $_SESSION["user_name"]){
                $usr_id = $user['id'];
              }
            }
            //友人のリストを取得
            //echo '<option value="'.友人名.'">'. 友人名 .'</option>';
          ?>
              <option value="gossy">gossy</option>
              <option value="kimikimi">kimikimi</option>
              <option value="shuya">shuya</option>
              <option value="w-001">w-001</option>
          </select>
        </div>
        送金金額を入力
          <input type="number" name="number" pattern="[0-9]*" id="number-pattern" value="">
          <button class="ui-btn ui-btn-inline">送金コード生成</button>
    </div>
    </div>
    <div data-role="footer">
      <div data-role="navbar">
      <ul>
        <li><a href="wallet.php" data-transition="none">財布</a></li>
        <li><a href="mining.php" data-transition="none">採掘</a></li>
        <li><a href="sent.php" class="ui-btn-active" data-transition="none">送金</a></li>
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
