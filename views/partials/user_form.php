
<body>
  <div class="container">
    <div class="col-xs-8 col-xs-offset-2">
      <div class="card border-info  ">
          <div class="card-header h1"><?php print ( FORMTITLE ); ?></div>
          <div class="card-body">
            <form method="POST">
              <div class="form-group">
                <input type="text"  class="form-control form-control-lg" name="user_name" placeholder="お名前を10文字以内で入力してください" required />
              </div>
              <div class="form-group">
                <input type="text"  class="form-control form-control-lg" name="email" placeholder="Emailで入力してください" required />
              </div>
              <div class="form-group">
                <input type="password" class="form-control form-control-lg" name="password" placeholder="Passwordを5~15文字以内で入力してください" required />
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