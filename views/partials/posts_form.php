<div class="container">
    <div class="card">
        <div class="card-header"><h1><?php print( TEXT );?></h1></div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="title">タイトル</label>
                    <input type="text" class="form-control" name="title" placeholder="タイトルを30文字以内で入力してください" 
                    value="<?php isset( $_POST['title'] ) ? print h( $_POST['title'] ): '' ; ?>" /required>
                </div>
                <div class="form-group">
                    <label for="content">本文</label>
                    <textarea class="form-control" rows="5" name="content" 
                    placeholder="本文を200文字以内で入力してください" /required><?php isset( $_POST['content'] ) ? print h( $_POST['content'] ): ''; ?>
                    </textarea>
                </div>
                <button type="submit" class="btn btn-info" name="action">Submit</button>
            </form>
        </div>
    </div>
</div>