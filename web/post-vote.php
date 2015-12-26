<?php

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */

/**
 * Those parameters suppose to be equals to
 * www/app/config/parameters.yml
 */

$dbname   = 'mage_brazuca';
$host     = 'localhost';
$user     = 'root';
$password = '123123123';

header('Content-Type: application/json');

try {
    $dbh = new PDO(sprintf('mysql:dbname=%s;host=%s', $dbname, $host), $user, $password);

    /**
     * Preparing data against SQL injection
     */

    $postIds = array();
    $userId  = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;

    if (isset($_POST['post_ids'])) {
        foreach ($_POST['post_ids'] as $postId) {
            $postIds[] = (int) $postId;
        }
    }

    /**
     * If there is no proper data exit
     */
    if (!$postIds || !$userId) {
        exit;
    }

    $sth = $dbh->prepare(sprintf(
        'SELECT post_id FROM post_vote WHERE post_id IN (%s) AND user_id = %s',
        implode(',', $postIds),
        $userId
    ));

    $sth->execute();

    $result = $sth->fetchAll();

    $data = array();

    if ($result) {
        foreach ($result as $row) {
            $data[] = $row['post_id'];
        }
    }

    echo json_encode(array(
        'data' => $data,
    ));
} catch (Exception $e) {
    echo json_encode(array(
        'error' => $e->getMessage(),
    ));
}
