
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="js/style.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="stylesheet" href="../css/style2.css">

    <title>PHP easy-bulletinBoard</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="http://code.createjs.com/easeljs-0.7.1.min.js"></script>
    <script type="text/javascript" src="../js/main.js"></script>
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
  <!-- Sidebar navigation-->
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">PHP easy-bulletinBoard</a>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap">
        <a class="nav-link" href="signout.php">Signout</a>
      </li>
    </ul>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <?php if ( isAuthenticated() ):  ?>
            <li class="nav-item">
              <a class="nav-link" href="posts.php">
                <span data-feather="file"></span>
                新規投稿
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="users.php">
                <span data-feather="shopping-cart"></span>
                ユーザ一覧
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user_edit.php">
                <span data-feather="bar-chart-2"></span>
                ユーザ情報編集
              </a>
            </li>
            <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="register.php">
                <span data-feather="bar-chart-2"></span>
                新規登録
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="authenticate.php">
                <span data-feather="bar-chart-2"></span>
                ログイン
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
<body>