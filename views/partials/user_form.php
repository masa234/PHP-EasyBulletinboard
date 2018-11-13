<?php $fname = basename( $_SERVER['PHP_SELF'] , ".php");?>
<body>
  <div class="container">
    <div class="col-xs-8 col-xs-offset-2">
      <div class="card border-info">
          <div class="card-header h1"><?php print ( FORMTITLE ); ?></div>
          <div class="card-body">
            <form method="POST">
              <div class="form-group">
                <p>ユーザ名</p>
                <input type="text"  class="form-control" name="user_name" placeholder="お名前を10文字以内で入力してください" 
                value ="<?php isset( $_POST['user_name'] ) ? print h( $_POST['user_name'] ): print '' ; ?>" required />
              </div>
              <?php if ( $fname != 'authenticate' ): ?>
              <div class="form-group">
                <p>ニックネーム</p>
                <input type="text"  class="form-control" name="nickname" placeholder="nicknameを入力してください" 
                value ="<?php isset( $_POST['nickname'] ) ? print h( $_POST['nickname'] ): print '' ; ?>" required />
              </div>
              <div class="form-group">
                <p>メールアドレス</p>
                <input type="email"  class="form-control" name="email" placeholder="Emailで入力してください" 
                value ="<?php isset( $_POST['email'] ) ? print h( $_POST['email'] ): print '' ; ?>" required />
              </div>
              <?php endif; ?>
              <div class="form-group">
                <p>パスワード:<span id ='password_length'>0</span>文字<span>( 半角英数字5から15文字以内でお願いします。)</span></p>
                <input type="password"  class="form-control" name="password" placeholder="Passwordを5~15文字以内で入力してください"  
                value ="<?php isset( $_POST['password'] ) ? print h( $_POST['password'] ): print '' ; ?>" required />
              </div>
              <button type="submit" class="btn btn-lg btn-info" name= "action"><?php print ( BUTTONTEXT ); ?></button>
              <a href="<?php print ( URL ); ?>"><?php print ( LINKTEXT ); ?></a>
            </form>
          </div>
      </div>
    </div>
  </div>
</body>
</html>