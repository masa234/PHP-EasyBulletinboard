<div class="container">
    <div class="card">
        <div class="card-header"><h1><?php print( TEXT );?></h1></div>
        <div class="card-body">
            <form method="POST">
                <?php if ( isset( $post['id'] ) ): ?>
                <input type="hidden" name="post_id" value="<?php print h( $post['id'] ); ?>">
                <?php endif; ?>
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" class="form-control" name="title" placeholder="タイトルを30文字以内で入力してください" 
                    <?php if ( isset( $_POST['title'] ) ): ?> 
                    value="<?php print h( $_POST['title'] ); ?>"
                    <?php elseif ( isset( $post['title'] ) ): ?>
                    value="<?php print h( $post['title'] ); ?>"
                    <?php else: ?>
                    value=""
                    <?php endif; ?>"/required>
                </div>
                <?php if ( isset( $_POST['content'] ) ): ?> 
                <?php $textarea_value= $_POST['content']; ?>
                <?php elseif ( isset( $post['content'] ) ): ?>
                <?php $textarea_value= $post['content']; ?>
                <?php else: ?>
                <?php $textarea_value= ''; ?>
                <?php endif; ?>
                <div class="form-group">
                    <label for="content">本文</label>
                    <textarea placeholder="本文を200文字以内で入力してください" rows="5" class="form-control" name="content" 
                    /required><?php print h( $textarea_value ); ?></textarea>
                </div>
                <button type="submit" class="btn btn-info" name="action">Submit</button>
            </form>
        </div>
    </div>
</div>