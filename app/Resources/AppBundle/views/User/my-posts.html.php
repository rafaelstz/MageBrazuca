<?php $view->extend('AppBundle:Default:layout.html.php'); ?>

<?php
    $postHelper = $view['postHelper'];
    $userHelper = $view['userHelper'];
?>

<h1>Meus Posts</h1>

<?php if ($myPosts) : ?>
<div id="my-posts-posts-box">
    <?php foreach ($myPosts as $post) : ?>
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
        <span class="post-delete" onclick="MyPosts.remove(<?php echo $post->getId(); ?>)">
            <i class="fa fa-times post-delete-icon"></i>
        </span>
    </div>
    <input type="hidden" name="post_id[]" value="<?php echo $post->getId(); ?>" />
    <?php endforeach; ?>

    <?php
        $previousPage = $currentPage - 1;
        $nextPage     = $currentPage + 1;
    ?>

    <?php if ($previousPage > 0) : ?>
    <a id="posts-previous-page" href="/post/all/<?php echo $previousPage; ?>">Anterior</a>
    <?php endif; ?>
    <?php if ($currentPage < $maxPage) : ?>
    <a id="posts-next-page" href="/post/all/<?php echo $nextPage; ?>">Próxima</a>
    <?php endif; ?>
</div>

<link rel="stylesheet" href="/css/font-awesome.min.css" type="text/css" media="all" />
<script type="text/javascript" src="/js/user/my-posts.js"></script>
<?php else : ?>
<p>Você não tem posts.</p>
<?php endif; ?>