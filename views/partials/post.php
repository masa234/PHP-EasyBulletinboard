
<div class="container">
    <div class="card card--extend">
    <div class="card-body">
        <?php $post_image = '../images/' . $post['image']; ?>
        <?php if ( file_exists( $post_image ) && ! is_dir( $post_image ) ): ?>
        <img src=<?= h( $post_image ) ?> class="img-circle post-image" alt="...">
        <?php endif; ?> 
        <h1 class="card-title"><?= h( $post['title'] ); ?></h1>

        <a class="post-user-link" href = "user_show.php?id=<?= h( $post['user_id'] ) ?>">
            <?php $post_image = '../images/' . get_user_info( $post['user_id'], 'image' ); ?>
            <?php if ( file_exists( $post_image ) && ! is_dir( $post_image ) ): ?>
            <img src=<?= h( $post_image ) ?> class="img-circle user-image-short" alt="...">
            <?php endif; ?> 
            <?= h( get_user_info( $post['user_id'], 'user_name' ) ) ?>( @<?= h( get_user_info( $post['user_id'], 'nickname' ) ) ?> )
        </a>

        <p class="card-body">
        <div class ="post-content">
        <?= h( $post['content'] ); ?>
        </div>
        </p>

        <?php if ( ! is_liked( $post['id'] ) ): ?>
        <form action="" method="post">
        <input type="hidden" name="post_id" value="<?= h( $post['id'] ); ?>">
        <input type="submit" value="いいね <?=h ( get_post_like_users( $post['id'], 'count' ) ) ?>" name="like" class="btn btn-info">
        </form>

        <?php else: ?>
        <form action="" method="post">
        <input type="hidden" name="post_id" value="<?= h( $post['id'] ); ?>">
        <input type="submit" value="いいねを外す<?=h ( get_post_like_users( $post['id'], 'count' ) ) ?>" name="unlike" class="btn btn-danger">
        </form>
        <?php endif; ?>
        
        <?php if ( ! is_retweet( $post['id'] ) ): ?>
        <form action="" method="post">
        <input type="hidden" name="post_id" value="<?= h( $post['id'] ); ?>">
        <input type="submit" value="retweet" name="retweet" class="btn btn-info">
        </form>

        <?php else: ?>
        <form action="" method="post">
        <input type="hidden" name="post_id" value="<?= h( $post['id'] ); ?>">
        <input type="submit" value="retweetを外す" name="unretweet" class="btn btn-primary">
        </form>
        <?php endif; ?>

        <!-- // ログインユーザの投稿の場合のみ、編集ボタン、削除ボタンを設置します。 -->
        <?php if ( isCurrentUser( 'posts', $post['id'] ) ): ?>
        <a class="btn btn-info" href="post_edit.php?id=<?= h( $post['id'] ); ?>" role="button">編集する</a>
        <form action="" method="post">
        <input type="hidden" name="post_id" value="<?= h( $post['id'] ); ?>">
        <input type="submit" value="削除する" name="post_delete" class="btn btn-danger" onSubmit="check()">
        </form>
        <?php endif; ?>
    </div>
    </div>
</div>