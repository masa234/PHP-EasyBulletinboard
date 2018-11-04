
<?php if ( isset( $errors ) && count( $errors ) > 0 ): ?> 
<div class="alert alert-dismissible alert-warning">
    <h4 class="alert-heading">Warning!</h4>
    <?php foreach( $errors as $error ): ?>
    <p class="mb-0"><?php print h( $error ) ?></p>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<?php if ( isset( $success_message ) ): ?>
<div class="alert alert-dismissible alert-info">
    <strong>完了</strong>
    <?php print h( $success_message ) ?>
</div>
<?php endif ; ?>
