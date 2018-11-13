
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
  </title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
  <?php if ( isAuthenticated() ): ?>
  <link href="../css/after_register.css" rel="stylesheet">
  <?php else: ?>
  <link href="../css/before_register.css" rel="stylesheet">
  <?php endif; ?>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script><script type="text/javascript" src="./footerFixed.js"></script>
</head>
<script type="text/javascript">
  function check(){

    if( window.confirm( 'Are you sure?' ) ){

      return true;

    } else{

      return false;

    }

  }

  function countLength( text, field, count ) {
  
    document.getElementById( field ).innerHTML = text.length;

  } 

</script>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">
        php-bulletinboard
      </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarEexample">
      <ul class="navbar-nav mr-auto">
        <?php if ( ! isAuthenticated() ): ?>
        <li class="nav-item">
          <a class="nav-link text-white" href="register.php">新規登録</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="authenticate.php">ログイン</a>
        </li>
        <?php else: ?>
        <li class="nav-item">
          <a class="nav-link text-white" href="posts.php">新規投稿</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="signout.php">ログアウト</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
</body>
