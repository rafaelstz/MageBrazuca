<?php
    $userHelper  = $view['userHelper'];
    $searchQuery = isset($searchQuery) ? $searchQuery : null;
?>

<div id="header-full">
    <div id="header">
        <div id="logo">
            <a href="/">
                <img src="/images/mage-brazuca-logo.png" alt="MageBrazuca" />
            </a>
        </div>
        <div id="search-box">
            <input type="text" id="search" placeholder="busca"<?php if ($searchQuery) : ?> value="<?php echo $searchQuery; ?>"<?php endif; ?> />
        </div>
        <?php if (!$userHelper->isUserLogged()) : ?>
        <a id="header-sign-up-box" class="header-link" href="/user/create">
            <span class="header-link-span">Cadastro</span>
        </a>
        <a id="header-login-box" class="header-link" href="/user/login">
            <span class="header-link-span">Login</span>
        </a>
        <?php else: ?>
        <?php $user = $userHelper->getLoggedUser(); ?>
        <div id="header-user-logged-box" >
            <a id="header-user-logged-image"<?php if (!$user->getPicturePath()) : ?> class="header-user-logged-image-no-image"<?php else : ?> <?php echo $userHelper->getImageStyleToHeader($user->getPicturePath()); ?><?php endif; ?> href="/user/account"></a>
            <a id="header-logout" href="/user/logout">Logout</a>
        </div>
        <a id="header-new-post-box" class="header-link" href="/post/create">
            <span class="header-link-span">Novo Post</span>
        </a>
        <a id="header-my-posts-box" class="header-link" href="/user/my-posts">
            <span class="header-link-span">Meus Posts</span>
        </a>
        <?php endif; ?>
    </div>
</div>
