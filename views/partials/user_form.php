<?php $current = get_current() ?>
<body>
  <div class="container">
    <div class="col-xs-8 col-xs-offset-2">
      <div class=" border-info">
          <div class="-header h1"><?php print ( FORMTITLE ); ?></div>
          <div class="-body">
            <form class="needs-validation" method="POST" <?php if ( $current != 'authenticate' ): ?>enctype="multipart/form-data"<?php endif; ?> novalidate>
              
              <?php if ( $current != 'authenticate' ): ?>
              <div class="form-group">
                <p>ユーザ名</p>
                <input type="text"  class="form-control" name="user_name" placeholder="お名前を10文字以内で入力してください" 
                value="<?= h( get_user_value( 'user_name' ) ) ?>" required />
              </div>
              <?php endif; ?>
              
              <div class="form-group">
                <p>ニックネーム</p>
                <input type="text"  class="form-control" name="nickname" placeholder="nicknameを半角英字と半角数字の組み合わせのみの5文字以上15文字以下で入力してください" 
                value="<?= h( get_user_value( 'nickname' ) ) ?>" required />
              </div>

              <?php if ( $current != 'authenticate' ): ?>
              <div class="form-group">
                <p>メールアドレス</p>
                <input type="email"  class="form-control" name="email" placeholder="Emailを入力してください" 
                value="<?= h( get_user_value( 'email' ) ) ?>" required />
              </div>
              <?php endif; ?>

              <?php if ( $current == 'user_edit' ): ?>
              <div class="form-group">
                <p>現在のパスワード</p>
                <input type="password"  class="form-control" name="current_password" placeholder="現在のパスワードを入力してください"  
                value="<?= h( get_Post( 'current_password' ) ) ?>" required />
              </div>
              <?php endif; ?>
              
              <div class="form-group">
                <p><?php print $current == 'user_edit' ? '新しいパスワード' : 'パスワード' ?></p>
                <input type="password"  class="form-control" name="password" placeholder="passwordを半角英小文字大文字数字をそれぞれ1種類以上含む5文字以上15文字以下で入力してください"  
                value="<?= h( get_Post( 'password' ) ) ?>" required />
              </div>
              <?php if ( $current != 'authenticate' ): ?>
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