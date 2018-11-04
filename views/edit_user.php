<?php 

// ユーザ情報編集画面

require (  "../setting_func.php" );
require ( get_functions_dir() . "/dbconfig.php" );
require ( get_functions_dir() . "/session.php" );
require ( get_functions_dir() . "/user.php" );

require_authenticate();
include ( get_views_dir() . "/navbar.php" );

// 更新ボタンを押したとき 、更新処理
if ( isset( $_POST['action'] ) ) {
	user_update( $_POST['user_name'], $_POST['email'], $_POST['password']  );
} 
?>

<!-- define について後で調べる -->

<body>
  <div class="container">
    <div class="col-xs-8 col-xs-offset-2">
      <div class="card border-info  ">
          <div class="card-header h1">ユーザ情報編集</div>
          <div class="card-body">	
            <form method="POST">
              <div class="form-group">
                <input type="text"  class="form-control form-control-lg" name="user_name" placeholder="お名前を10文字以内で入力してください"  value="<?php print h( session_get( 'user_name' ) ); ?>" required />
              </div>
              <div class="form-group">
                <input type="text"  class="form-control form-control-lg" name="email" placeholder="Emailで入力してください"  value="<?php print h( session_get( 'email' ) ); ?>"required />
              </div>
              <div class="form-group">
                <input type="password" class="form-control form-control-lg" name="password" placeholder="Passwordを5~15文字以内で入力してください" value="<?php print h( session_get( 'password' ) ); ?>" required />
              </div>
              <button type="submit" class="btn btn-lg btn-info" name= "action">編集する</button>
            </form>
          </div>
      </div>
    </div>
  </div>
</body>
</html>