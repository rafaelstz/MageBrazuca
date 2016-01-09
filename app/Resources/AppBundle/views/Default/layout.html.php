<?php
/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
?>

<?php
    $userHelper = $view['userHelper'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php if (isset($title)) : echo $title; ?> - <?php endif; ?>MageBrazuca</title>
    <link rel="shortcut icon" href="/favicon.ico" title="Favicon" />
    <link rel="stylesheet" href="/css/main.css" type="text/css" media="all" />
    <link href='https://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="/js/base/jquery-1.11.3.min.js"></script>
    <?php if ($userHelper->isUserLogged()) : ?>
    <script>
        var currentUserId = <?php echo $userHelper->getLoggedUser()->getId(); ?>;
    </script>
    <?php endif; ?>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-72166283-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body>
    <?php
        echo $view->render('AppBundle:Default:header.html.php', array(
            'searchQuery' => isset($searchQuery) ? $searchQuery : null,
        ));
    ?>
    <div id="content">
        <?php echo $view->render('AppBundle:Default:notifications.html.php'); ?>
        <?php $view['slots']->output('_content'); ?>
    </div>

    <?php echo $view->render('AppBundle:Default:footer.html.php'); ?>

    <script type="text/javascript" src="/js/base/base.js"></script>

    <?php if ($userHelper->isUserLogged()) : ?>
    <script>
        Search.init();
        PostVote.updateItemsVoted(<?php echo $userHelper->getLoggedUser()->getId(); ?>);
    </script>
    <?php endif; ?>
</body>
</html>
