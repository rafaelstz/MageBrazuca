<?php
/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
?>

<div id="notification-box">
    <?php foreach ($app->getSession()->getFlashbag()->get('success') as $message) : ?>
        <div class="notification notification-success"><?php echo $message; ?></div>
    <?php endforeach; ?>

    <?php foreach ($app->getSession()->getFlashbag()->get('error') as $message) : ?>
        <div class="notification notification-error"><?php echo $message; ?></div>
    <?php endforeach; ?>
</div>
