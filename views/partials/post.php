<div class="container">
    <div class="card card--extend">
    <div class="card-body">
        <h1 class="card-title"><?php print h( $post['title'] ); ?></h1>
        <p class="card-body"><?php print h( $post['content'] ); ?></p>
        <form action="" method="post">
        <?php if ( isCurrentUserPost( $post['id'] ) ): ?>
        <input type="hidden" name="post_id" value="<?php print h( $post['id'] ); ?>">
        <input type="submit" value="削除する" name="post_delete" class="btn btn-danger" onsubmit="return check()">
        <?php endif; ?>
        </form>
    </div>
    </div>
</div>