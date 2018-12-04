
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style2.css">

    <title>PHP easy-bulletinBoard</title>
  </head>
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
            <li class="nav-item">
              <a class="nav-link" href="user_show.php?id=<?= h( get_current_user_id() ) ?>">
                <span data-feather="bar-chart-2"></span>
                マイページ
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

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="http://code.createjs.com/easeljs-0.7.1.min.js"></script>
    <script type="text/javascript">
      var check = function check(){

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

