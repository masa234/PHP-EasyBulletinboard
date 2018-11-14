<div class="container">
    <div class="card card--extend">
    <div class="card-body">
        <h1 class="card-title"><?php print h( $post['title'] ); ?></h1>
        <p class="card-body"><?php print h( $post['content'] ); ?></p>
        <!-- // ログインユーザの投稿の場合のみ、編集ボタン、削除ボタンを設置します。 -->
        <?php if ( isCurrentUserPost( $post['id'] ) ): ?>
        <a class="btn btn-info" href="post_edit.php?id=<?php print h( $post['id'] ); ?>" role="button">編集する</a>
        <form action="" method="post">
        <input type="hidden" name="post_id" value="<?php print h( $post['id'] ); ?>">
        <input type="submit" value="削除する" name="post_delete" class="btn btn-danger" onsubmit="return check()">
        <?php endif; ?>
        </form>
    </div>
    </div>
</div>