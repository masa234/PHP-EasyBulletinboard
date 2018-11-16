<div class="container">
    <div class="card card--extend">
    <div class="card-body">
        <img src="../images/<?php print h( $user['image'] ) ?>" class="img-circle user-image" alt="...">
        <h1 class="card-title">@<?php print h( $user['nickname'] ); ?></h1>
        <p class="card-body">
        <div class ="user-content">
        <?php print h( $user['id'] ); ?>
        </div>
        </p>
    </div>
    </div>
</div>