<?php
/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
?>

<?php $view->extend('AppBundle:Default:layout.html.php'); ?>

<h1>DASHBOARD</h1>

<ul>
    <li><a href="/word/create">add word</a></li>
    <li><a href="/expression/create">add expression</a></li>
    <li><a href="/pronunciation/create">add pronunciation</a></li>
    <li><a href="/pronunciation-vote/create">add pronunciation-vote</a></li>
</ul>

<h2>Expression List</h2>

<table>
    <thead>
    <th>ID</th>
    <th>Expression</th>
    <th>Upvote</th>
    <th>Downvote</th>
    </thead>
    <?php foreach ($expressionList as $expression) : ?>
    <tr>
        <td><?php echo $expression->getId(); ?></td>
        <td><a href="/pronunciation/<?php echo $expression->getId(); ?>"><?php echo $expression->getLabel(); ?> (<?php echo $expression->getPronunciationTotal(); ?>)</a></td>
        <td><?php echo $expression->getPronunciationUpvoteTotal(); ?></td>
        <td><?php echo $expression->getPronunciationDownvoteTotal(); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

