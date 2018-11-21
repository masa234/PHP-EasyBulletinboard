<?php $fname = basename( $_SERVER['PHP_SELF'] , ".php");?>
<body>
  <div class="container">
    <div class="col-xs-8 col-xs-offset-2">
      <div class=" border-info">
          <div class="-header h1"><?php print ( FORMTITLE ); ?></div>
          <div class="-body">
            <form method="POST" <?php if ( $fname != 'authenticate' ): ?>enctype="multipart/form-data"<?php endif; ?> >
              <?php if ( $fname != 'authenticate' ): ?>
              <div class="form-group">
                <p>ユーザ名</p>
                <input type="text"  class="form-control" name="user_name" placeholder="お名前を10文字以内で入力してください" 
                <?php if ( isset( $_POST['user_name'] ) ): ?> 
                value ="<?php print h( $_POST['user_name'] ); ?>"
                <?php elseif ( session_get( 'user_name' ) ):?>
                value ="<?php print h( session_get( 'user_name' )  ); ?>"
                <?php else: ?>
                <?php endif; ?>
                " required />
              </div>
              <?php endif; ?>
              <div class="form-group">
                <p>ニックネーム</p>
                <input type="text"  class="form-control" name="nickname" placeholder="nicknameを半角英字と半角数字の組み合わせのみの5文字以上15文字以下で入力してください" 
                <?php if ( isset( $_POST['nickname'] ) ): ?> 
                value ="<?php print h( $_POST['nickname'] ); ?>"
                <?php elseif ( session_get( 'nickname' ) ):?>
                value ="<?php print h( session_get( 'nickname' )  ); ?>"
                <?php else: ?>
                <?php endif; ?>
                " required />
              </div>
              <?php if ( $fname != 'authenticate' ): ?>
              <div class="form-group">
                <p>メールアドレス</p>
                <input type="email"  class="form-control" name="email" placeholder="Emailで入力してください" 
                <?php if ( isset( $_POST['email'] ) ): ?> 
                value ="<?php print h( $_POST['email'] ); ?>"
                <?php elseif ( session_get( 'email' ) ):?>
                value ="<?php print h( session_get( 'email' )  ); ?>"
                <?php else: ?>
                <?php endif; ?>
                " required />
              </div>
              <?php endif; ?>
              <div class="form-group">
                <p>パスワード:<span id ='password_length'>0</span>文字<span></span></p>
                <input type="password"  class="form-control" name="password" placeholder="passwordを半角英小文字大文字数字をそれぞれ1種類以上含む5文字以上15文字以下で入力してください"  
                <?php if ( isset( $_POST['password'] ) ): ?> 
                value ="<?php print h( $_POST['password'] ); ?>"
                <?php else: ?>
                <?php endif; ?>
                " required />
              </div>
              <?php if ( $fname != 'authenticate' ): ?>
              <dd><input type="file" name="image"></dd>
              <?php endif; ?>
              <button type="submit" class="btn btn-lg btn-info" name= "action"><?php print ( BUTTONTEXT ); ?></button>
              <a href="<?php print ( URL ); ?>"><?php print ( LINKTEXT ); ?></a>
            </form>
          </div>
      </div>
    </div>
  </div>
</body>
</html>