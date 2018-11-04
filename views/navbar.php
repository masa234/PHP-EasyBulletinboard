
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    どろっぷ
  </title>
  <link href="../css/bootstrap.css" rel="stylesheet">
  <?php if ( isAuthenticated() ):  ?> 
  <?php if ( isAdmin() ):  ?> 
  <link href="../css/admin.css" rel="stylesheet"> 
  <?php else: ?>
  <link href="../css/after_register.css" rel="stylesheet"> 
  <?php endif; ?>
  <?php else: ?>
  <link href="../css/before_register.css" rel="stylesheet"> 
  <?php endif; ?>
</head>
<script type="text/javascript">
  function check(){

    if( window.confirm( 'Are you sure?' ) ){

      return true;

    } else{

      return false;

    }
    
  }
</script>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">
        DROP  
      </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarEexample">
      <ul class="navbar-nav mr-auto">
        <?php if ( isAuthenticated() ):  ?> 
        <li class="nav-item">
          <a class="nav-link text-primary" href="https://ysakasin.github.io/Umi/bootstrap-ja.html">DEMO<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="signout.php">ログアウト</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-primary" href="edit_user.php"; ?>ユーザ編集</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="events.php">イベントリスト</a>
        </li>
        <?php if ( isAdmin() ):  ?> 
        <li class="nav-item">
          <a class="nav-link text-white" href="event_register.php">イベントを追加する</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="users.php">ユーザ一覧</a>
        </li>
        <?php endif;  ?> 
        <?php else: ?>
        <li class="nav-item">
          <a class="nav-link text-white" href="register.php">新規登録</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="authenticate.php">ログイン</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
</body>