<?php $post = isset( $post ) ? $post : null ?> 

<div class="container">
    <div class="card">
        <div class="card-header"><h1><?php print( TEXT );?></h1></div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <?php if ( isset( $post['id'] ) ): ?>
                <input type="hidden" name="post_id" value="<?=h ( $post['id'] ); ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" class="form-control" name="title" placeholder="タイトルを30文字以内で入力してください" 
                    value= "<?=h ( get_post_value( 'title', $post ) ) ?>" /required>
                </div>

                <div class="form-group">
                    <label for="content">本文</label>
                    <textarea placeholder="本文を200文字以内で入力してください" rows="5" class="form-control" name="content" 
                    /required><?=h ( get_post_value( 'content', $post ) ) ?></textarea>
                </div>
                <input type="file" name="image">
                <button type="submit" class="btn btn-info" name="action">Submit</button>
            </form>
        </div>
    </div>
</div>