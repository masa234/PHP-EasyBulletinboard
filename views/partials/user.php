<div class="container">
    <div class="card card--extend">
    <div class="card-body">
        <?php $user_image = '../images/' . $user['image']; ?>
        <?php if ( file_exists( $user_image ) &&  ! is_dir( $user_image ) ): ?>
        <img src=<?php print h( $user_image ) ?> class="img-circle user-image" alt="...">
        <?php endif; ?>
        <h1 class="card-title">@<?php print h( $user['nickname'] ); ?></h1>
        <p class="card-body">
        <div class ="user-content">
        <?php print h( $user['id'] ); ?>
        </div>
        </p>
    </div>
    </div>
</div>