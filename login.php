<?php
session_start();

// エラーメッセージを格納する変数を初期化
$error_message = "";

// ログインボタンが押されたかを判定
// 初めてのアクセスでは認証は行わずエラーメッセージは表示しないように
if (isset($_POST["login"])) {
  //mySQL接続
  try {
    $pdo = new PDO('mysql:host=localhost;dbname=sfcoin_test;charset=utf8', 'root', 'root', array(PDO::ATTR_EMULATE_PREPARES => false));
  } catch (PDOException $e) {
    exit('データベース接続失敗。' . $e->getMessage());
  }
  //user名一致を探す
  $user_info = $pdo->query('select * from user');
  foreach ($user_info as $crom) {
    if ($_POST["user_name"] == $crom["name"] && $_POST["password"] == $crom["password"]) {

      // ログインが成功した証をセッションに保存
      $_SESSION["user_name"] = $crom["name"];

      // 管理者専用画面へリダイレクト
      $login_url = "http://{$_SERVER["HTTP_HOST"]}/sfcoin/wallet.php";
      header("Location: {$login_url}");
      exit;
    }
  }
  $error_message = "ユーザ名もしくはパスワードが違っています。";
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
    <div id="LOGIN">
      <?php
       if($error_message) {
        print '<font color="red">'.$error_message.'</font>';
       }
      ?>
      <div class="ui-bar ui-bar-d">
        <h3>
          LOGIN
        </h3>
      </div>
      <div class="ui-body ui-body-d">
      <form action="login.php" data-transition="none" method="post">
          <label for="text-basic">USER NAME:</label>
          <input type="text" name="user_name" id="text-basic" value="">
          <label for="text-basic">PASSWORD:</label>
          <input type="text" name="password" id="text-basic" value="">
          <input name="login" type="submit" value="LOGIN" />
        </form>
        </div>
      </div>
    </div>
    <div data-role="footer">
      <p style="text-align:center;">
        Copyright 2015 SFCoin project
      </p>
    </div>
  </div>
</body>
</html>
