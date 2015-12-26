<?php $view->extend('AppBundle:Default:layout.html.php'); ?>

<?php
    $postHelper = $view['postHelper'];
    $userHelper = $view['userHelper'];
?>

<div id="home-column-most-voted-of-the-month" class="home-column">
    <h2 id="home-most-voted-of-the-month-title" class="home-column-title">Os mais votados da semana</h2>
    <a id="home-most-voted-of-the-month-see-all" class="home-column-see-all" href="/post/all">Ver todos os posts</a>
    <?php foreach ($mostVotedOfTheWeek as $post) : ?>
    <div class="post">
        <div class="post-upvotes" id="post-upvote-<?php echo $post->getId(); ?>" onclick="PostVote.vote(<?php echo $post->getId(); ?>, <?php echo $post->getUser()->getId(); ?>)"><?php echo $post->getUpvoteTotal(); ?></div>
        <div class="post-title">
            <a class="post-title-link" href="<?php echo $post->getUrl(); ?>" target="_blank"><?php echo $post->getTitle(); ?></a>
        </div>
        <div class="post-user-box">
            <a class="post-user-image" href="/user/<?php echo $post->getUser()->getUsername(); ?>" <?php if ($post->getUser()->getPicturePath()) : echo $userHelper->getImageStyleToPostList($post->getUser()->getPicturePath()); endif; ?>></a>
            <span class="post-user-username">by <a class="post-user-username-link" href="/user/<?php echo $post->getUser()->getUsername(); ?>"><?php echo $post->getUser()->getUsername(); ?></a></span>
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
<div id="home-column-top-users" class="home-column">
    <h2 id="top-developers-title" class="home-column-title">Top Desenvolvedores</h2>
    <div id="top-users-box">
    <?php foreach ($topDevelopers as $user) : ?>
        <div class="top-user">
            <a class="top-user-image<?php if (!$user->getPicturePath()) : ?> top-user-image-no-image<?php endif; ?>" href="/user/<?php echo $user->getUsername(); ?>" <?php if ($user->getPicturePath()) : echo $userHelper->getImageStyleToTopDevelopers($user->getPicturePath()); endif; ?>></a>
            <a class="top-user-fullname" href="/user/<?php echo $user->getUsername(); ?>"><?php echo $user->getFullname(); ?></a>
            <a class="top-user-username" href="/user/<?php echo $user->getUsername(); ?>"><?php echo $user->getUsername(); ?></a>
            <span class="top-user-upvote-total"><?php echo $user->getUpvoteTotal(); ?></span>
        </div>
    <?php endforeach; ?>
    </div>
</div>
