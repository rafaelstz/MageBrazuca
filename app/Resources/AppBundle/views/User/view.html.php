<?php
/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
?>

<?php $view->extend('AppBundle:Default:layout.html.php'); ?>

<?php
    $userHelper = $view['userHelper'];
    $postHelper = $view['postHelper'];
?>

<div id="user-view">
    <div id="user-info">
        <div id="user-view-image-box">
            <?php if ($user->getPicturePath()) : ?>
            <img id="user-view-image" src="<?php echo $userHelper->getImageToUserView($user->getPicturePath()); ?>" alt="<?php echo $user->getFullname(); ?>" />
            <?php else : ?>
            <img id="user-view-image" src="/images/" alt="<?php echo $user->getFullname(); ?>" />
            <?php endif; ?>
        </div>
        <div id="user-view-data-box">
            <h1 id="user-view-user-fullname"><?php echo $user->getFullname(); ?></h1>
            <span id="user-view-user-location"><?php echo $user->getLocation(); ?></span>
            <?php
            /* @TODO: add user member for 1 year, 3 months and 7 days
            <span id="user-view-user-username"><?php echo $user->getUsername(); ?></span>*/ ?>
            <div id="user-view-contacts-box">
                <?php if ($user->getContactWebsite()) : ?>
                <a id="user-view-user-website" class="user-view-user-contact" href="<?php echo $user->getContactWebsite(); ?>" target="_blank">
                    <i class="fa fa-globe tooltip user-view-user-contact-icon" title="Magento Certified Developer"></i>
                </a>
                <?php endif; ?>
                <?php if ($user->getContactTwitter()) : ?>
                <a id="user-view-user-twitter" class="user-view-user-contact" href="https://www.twitter.com/<?php echo $user->getContactTwitter(); ?>" target="_blank">
                    <i class="fa fa-twitter tooltip user-view-user-contact-icon" title="Twitter"></i>
                </a>
                <?php endif; ?>
                <?php if ($user->getContactLinkedIn()) : ?>
                <a id="user-view-user-linkedin" class="user-view-user-contact" href="<?php echo $user->getContactLinkedIn(); ?>" target="_blank">
                    <i class="fa fa-linkedin tooltip user-view-user-contact-icon" title="Twitter"></i>
                </a>
                <?php endif; ?>
                <?php if ($user->getContactCertification()) : ?>
                <a id="user-view-user-certification" class="user-view-user-contact" href="<?php echo $user->getContactCertification(); ?>" target="_blank">
                    <i class="fa fa-certificate tooltip user-view-user-contact-icon" title="Magento Certified Developer"></i>
                </a>
                <?php endif; ?>
                <?php if ($user->getContactGithub()) : ?>
                <a id="user-view-user-github" class="user-view-user-contact" href="https://www.github.com/<?php echo $user->getContactGithub(); ?>" target="_blank">
                    <i class="fa fa-github tooltip user-view-user-contact-icon" title="Magento Certified Developer"></i>
                </a>
                <?php endif; ?>
                <?php if ($user->getContactStackOverflow()) : ?>
                <a id="user-view-user-stackoverflow" class="user-view-user-contact" href="<?php echo $user->getContactStackOverflow(); ?>" target="_blank">
                    <i class="fa fa-stack-overflow tooltip user-view-user-contact-icon" title="Magento Certified Developer"></i>
                </a>
                <?php endif; ?>
            </div>
            <span id="user-view-user-about"><?php echo $user->getAbout(); ?></span>
        </div>
    </div>
    <div class="clear"></div>
    <div id="user-view-posts-box">
        <?php foreach ($posts as $post) : ?>
            <div class="post">
                <div class="post-upvotes" id="post-upvote-<?php echo $post->getId(); ?>" onclick="PostVote.vote(<?php echo $post->getId(); ?>, <?php echo $post->getUser()->getId(); ?>)"><?php echo $post->getUpvoteTotal(); ?></div>
                <div class="post-title">
                    <a class="post-title-link" href="<?php echo $post->getUrl(); ?>" target="_blank"><?php echo $post->getTitle(); ?></a>
                </div>
                <div class="post-tags-and-date-box">
                    <div class="post-tags">
                        <?php echo $postHelper->getFormattedTag($post->getTag()); ?>
                    </div>
                    <span class="post-title-date"><?php echo $postHelper->getFormattedDate($post->getCreatedAt()); ?></span>
                </div>
            </div>
            <input type="hidden" name="post_id[]" value="<?php echo $post->getId(); ?>" />
        <?php endforeach; ?>
    </div>
</div>

<link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" media="all" />
