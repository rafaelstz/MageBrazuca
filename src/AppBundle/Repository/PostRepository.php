<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Service\PostService;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class PostRepository extends AbstractRepository
{
    /**
     * @param User $user
     * @return object
     */
    public function getToUserView(User $user)
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('AppBundle\Entity\Post', 'p');
        $rsm->addFieldResult('p', 'post_id', 'id');
        $rsm->addFieldResult('p', 'post_title', 'title');
        $rsm->addFieldResult('p', 'post_url', 'url');
        $rsm->addFieldResult('p', 'post_tag', 'tag');
        $rsm->addFieldResult('p', 'post_upvote_total', 'upvoteTotal');
        $rsm->addFieldResult('p', 'post_created_at', 'createdAt');

        $rsm->addJoinedEntityResult('AppBundle\Entity\User', 'u', 'p', 'user');
        $rsm->addFieldResult('u', 'user_id', 'id');
        $rsm->addFieldResult('u', 'user_username', 'username');
        $rsm->addFieldResult('u', 'user_picture_path', 'picturePath');

        $sql = sprintf("
        SELECT
            p.id           AS post_id,
            p.title        AS post_title,
            p.url          AS post_url,
            p.tag          AS post_tag,
            p.upvote_total AS post_upvote_total,
            p.created_at   AS post_created_at,
            p.updated_at   AS post_updated_at,
            u.id           AS user_id,
            u.username     AS user_username,
            u.picture_path AS user_picture_path
        FROM
            post AS p
        LEFT JOIN
            user AS u ON u.id = p.user_id
        WHERE
            p.user_id = %s
        ORDER BY
            p.upvote_total DESC,
            p.created_at ASC
        LIMIT
            50
        ",
        $user->getId());

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    /**
     * @return object
     */
    public function getMostVotedOfTheWeek()
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('AppBundle\Entity\Post', 'p');
        $rsm->addFieldResult('p', 'post_id', 'id');
        $rsm->addFieldResult('p', 'post_title', 'title');
        $rsm->addFieldResult('p', 'post_url', 'url');
        $rsm->addFieldResult('p', 'post_tag', 'tag');
        $rsm->addFieldResult('p', 'post_upvote_total', 'upvoteTotal');
        $rsm->addFieldResult('p', 'post_created_at', 'createdAt');

        $rsm->addJoinedEntityResult('AppBundle\Entity\User', 'u', 'p', 'user');
        $rsm->addFieldResult('u', 'user_id', 'id');
        $rsm->addFieldResult('u', 'user_username', 'username');
        $rsm->addFieldResult('u', 'user_picture_path', 'picturePath');

        $sql = "
        SELECT
            p.id           AS post_id,
            p.title        AS post_title,
            p.url          AS post_url,
            p.tag          AS post_tag,
            p.upvote_total AS post_upvote_total,
            p.created_at   AS post_created_at,
            p.updated_at   AS post_updated_at,
            u.id           AS user_id,
            u.username     AS user_username,
            u.picture_path AS user_picture_path,
            COUNT(*)       AS total
        FROM
            post_vote AS pv
        LEFT JOIN
            post AS p ON p.id = pv.post_id
        LEFT JOIN
            user AS u ON u.id = p.user_id
        WHERE
            pv.created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND NOW()
        GROUP BY
            pv.post_id
        ORDER BY
            p.upvote_total DESC
        LIMIT
            10
        ";

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    /**
     * @return object
     */
    public function getAllToHome()
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('AppBundle\Entity\Post', 'p');
        $rsm->addFieldResult('p', 'post_id', 'id');
        $rsm->addFieldResult('p', 'post_title', 'title');
        $rsm->addFieldResult('p', 'post_url', 'url');
        $rsm->addFieldResult('p', 'post_tag', 'tag');
        $rsm->addFieldResult('p', 'post_upvote_total', 'upvoteTotal');
        $rsm->addFieldResult('p', 'post_created_at', 'createdAt');

        $rsm->addJoinedEntityResult('AppBundle\Entity\User', 'u', 'p', 'user');
        $rsm->addFieldResult('u', 'user_id', 'id');
        $rsm->addFieldResult('u', 'user_username', 'username');
        $rsm->addFieldResult('u', 'user_picture_path', 'picturePath');

        $sql = sprintf("
        SELECT
            p.id           AS post_id,
            p.title        AS post_title,
            p.url          AS post_url,
            p.tag          AS post_tag,
            p.upvote_total AS post_upvote_total,
            p.created_at   AS post_created_at,
            p.updated_at   AS post_updated_at,
            u.id           AS user_id,
            u.username     AS user_username,
            u.picture_path AS user_picture_path
        FROM
            post AS p
        LEFT JOIN
            user AS u ON u.id = p.user_id
        ORDER BY
            p.created_at DESC
        LIMIT
            %d
        ",
        PostService::ALL_POST_LIMIT);

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    /**
     * @return object
     */
    public function getAll($offset, $limit)
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('AppBundle\Entity\Post', 'p');
        $rsm->addFieldResult('p', 'post_id', 'id');
        $rsm->addFieldResult('p', 'post_title', 'title');
        $rsm->addFieldResult('p', 'post_url', 'url');
        $rsm->addFieldResult('p', 'post_tag', 'tag');
        $rsm->addFieldResult('p', 'post_upvote_total', 'upvoteTotal');
        $rsm->addFieldResult('p', 'post_created_at', 'createdAt');

        $rsm->addJoinedEntityResult('AppBundle\Entity\User', 'u', 'p', 'user');
        $rsm->addFieldResult('u', 'user_id', 'id');
        $rsm->addFieldResult('u', 'user_username', 'username');
        $rsm->addFieldResult('u', 'user_picture_path', 'picturePath');

        $sql = sprintf("
        SELECT
            p.id           AS post_id,
            p.title        AS post_title,
            p.url          AS post_url,
            p.tag          AS post_tag,
            p.upvote_total AS post_upvote_total,
            p.created_at   AS post_created_at,
            p.updated_at   AS post_updated_at,
            u.id           AS user_id,
            u.username     AS user_username,
            u.picture_path AS user_picture_path
        FROM
            post AS p
        LEFT JOIN
            user AS u ON u.id = p.user_id
        ORDER BY
            p.created_at DESC
        LIMIT
            %d, %d
        ",
            $offset,
            $limit);

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    /**
     * @return int
     */
    public function getAllCount()
    {
        $query = $this
            ->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * @return object
     */
    public function getMyPosts(User $user, $offset, $limit)
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('AppBundle\Entity\Post', 'p');
        $rsm->addFieldResult('p', 'post_id', 'id');
        $rsm->addFieldResult('p', 'post_title', 'title');
        $rsm->addFieldResult('p', 'post_url', 'url');
        $rsm->addFieldResult('p', 'post_tag', 'tag');
        $rsm->addFieldResult('p', 'post_upvote_total', 'upvoteTotal');
        $rsm->addFieldResult('p', 'post_created_at', 'createdAt');

        $rsm->addJoinedEntityResult('AppBundle\Entity\User', 'u', 'p', 'user');
        $rsm->addFieldResult('u', 'user_id', 'id');
        $rsm->addFieldResult('u', 'user_username', 'username');
        $rsm->addFieldResult('u', 'user_picture_path', 'picturePath');

        $sql = sprintf("
        SELECT
            p.id           AS post_id,
            p.title        AS post_title,
            p.url          AS post_url,
            p.tag          AS post_tag,
            p.upvote_total AS post_upvote_total,
            p.created_at   AS post_created_at,
            p.updated_at   AS post_updated_at,
            u.id           AS user_id,
            u.username     AS user_username,
            u.picture_path AS user_picture_path
        FROM
            post AS p
        LEFT JOIN
            user AS u ON u.id = p.user_id
        WHERE
            u.id = %d
        ORDER BY
            p.created_at DESC
        LIMIT
            %d, %d
        ",
        $user->getId(),
        $offset,
        $limit);

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    /**
     * @return int
     */
    public function getMyPostsCount(User $user)
    {
        $query = $this
            ->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.id = ?1')
            ->setParameter(1, $user->getId())
            ->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * @return object
     */
    public function getByTag($tag, $offset, $limit)
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('AppBundle\Entity\Post', 'p');
        $rsm->addFieldResult('p', 'post_id', 'id');
        $rsm->addFieldResult('p', 'post_title', 'title');
        $rsm->addFieldResult('p', 'post_url', 'url');
        $rsm->addFieldResult('p', 'post_tag', 'tag');
        $rsm->addFieldResult('p', 'post_upvote_total', 'upvoteTotal');
        $rsm->addFieldResult('p', 'post_created_at', 'createdAt');

        $rsm->addJoinedEntityResult('AppBundle\Entity\User', 'u', 'p', 'user');
        $rsm->addFieldResult('u', 'user_id', 'id');
        $rsm->addFieldResult('u', 'user_username', 'username');
        $rsm->addFieldResult('u', 'user_picture_path', 'picturePath');

        $sql = sprintf("
        SELECT
            p.id           AS post_id,
            p.title        AS post_title,
            p.url          AS post_url,
            p.tag          AS post_tag,
            p.upvote_total AS post_upvote_total,
            p.created_at   AS post_created_at,
            p.updated_at   AS post_updated_at,
            u.id           AS user_id,
            u.username     AS user_username,
            u.picture_path AS user_picture_path
        FROM
            post AS p
        LEFT JOIN
            user AS u ON u.id = p.user_id
        WHERE
            FIND_IN_SET('%s', p.tag) > 0
        ORDER BY
            p.upvote_total DESC
        LIMIT
            %d, %d
        ",
        $tag,
        $offset,
        $limit);

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    /**
     * @return int
     */
    public function getByTagCount($tag)
    {
        $sql =  sprintf("SELECT COUNT(id) AS total FROM post WHERE FIND_IN_SET('%s', tag) > 0", $tag);

        $stmt = $this
            ->_em
            ->getConnection()
            ->prepare($sql);

        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @return object
     */
    public function getBySearchQuery($searchQuery, $offset, $limit)
    {
        $rsm = new ResultSetMapping();

        $rsm->addEntityResult('AppBundle\Entity\Post', 'p');
        $rsm->addFieldResult('p', 'post_id', 'id');
        $rsm->addFieldResult('p', 'post_title', 'title');
        $rsm->addFieldResult('p', 'post_url', 'url');
        $rsm->addFieldResult('p', 'post_tag', 'tag');
        $rsm->addFieldResult('p', 'post_upvote_total', 'upvoteTotal');
        $rsm->addFieldResult('p', 'post_created_at', 'createdAt');

        $rsm->addJoinedEntityResult('AppBundle\Entity\User', 'u', 'p', 'user');
        $rsm->addFieldResult('u', 'user_id', 'id');
        $rsm->addFieldResult('u', 'user_username', 'username');
        $rsm->addFieldResult('u', 'user_picture_path', 'picturePath');

        $sql = sprintf("
        SELECT
            p.id           AS post_id,
            p.title        AS post_title,
            p.url          AS post_url,
            p.tag          AS post_tag,
            p.upvote_total AS post_upvote_total,
            p.created_at   AS post_created_at,
            p.updated_at   AS post_updated_at,
            u.id           AS user_id,
            u.username     AS user_username,
            u.picture_path AS user_picture_path
        FROM
            post AS p
        LEFT JOIN
            user AS u ON u.id = p.user_id
        WHERE
            p.title REGEXP '[[:<:]]%s[[:>:]]'
        ORDER BY
            p.upvote_total DESC
        LIMIT
            %d, %d
        ",
        $searchQuery,
        $offset,
        $limit);

        $query = $this->_em->createNativeQuery($sql, $rsm);

        return $query->getResult();
    }

    /**
     * @return int
     */
    public function getBySearchQueryCount($searchQuery)
    {
        $sql =  sprintf("SELECT COUNT(id) AS total FROM post WHERE title REGEXP '[[:<:]]%s[[:>:]]'", $searchQuery);

        $stmt = $this
            ->_em
            ->getConnection()
            ->prepare($sql);

        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function updateTotalVotes(Post $post)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        UPDATE
            post

        LEFT JOIN (
            SELECT post_id, COUNT(*) AS total FROM post_vote WHERE post_id = :post_id_1
        ) AS upvote ON upvote.post_id = post.id

        SET
            upvote_total = upvote.total

        WHERE
            post.id = :post_id_2
	    ';

        $statement = $conn->prepare($sql);

        if ($post->getId()) {
            $statement->bindValue('post_id_1', $post->getId());
            $statement->bindValue('post_id_2', $post->getId());
        }

        return $statement->execute();
    }
}
