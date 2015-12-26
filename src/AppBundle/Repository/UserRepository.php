<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class UserRepository extends AbstractRepository
{
    /**
     * @param $username
     * @param $password
     * @return object
     */
    public function getUserByUsernameAndPassword(
        $username,
        $password
    ) {
        $query = $this->createQueryBuilder('u')
            ->where('u.username = ?1')
            ->andWhere('u.password = ?2')
            ->setParameter(1, $username)
            ->setParameter(2, $password)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param $username
     * @return object
     */
    public function findByUsername($username)
    {
        $query = $this->createQueryBuilder('u')
            ->where('u.username = ?1')
            ->setParameter(1, $username)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param $username
     * @param $email
     * @return object
     */
    public function hasGivenUsernameAndEmail($username, $email)
    {
        $stmt = $this->_em->getConnection()->prepare(sprintf("
        SELECT IF(COUNT(id) > 0, 1, 0) AS has_given_username_and_email
        FROM user WHERE username = '%s' OR email = '%s'
        ",
        $username,
        $email));

        $stmt->execute();

        return $stmt->fetchColumn();
    }

    /**
     * @return array
     */
    public function getTop()
    {
        /**
         * @TODO: FIX IT
         * I don't know WHY but I couldn't add the upvoteTotal in the UserEntity...
         * THUS, I have done a workaround thought out RAW SQL
         */
        $stmt = $this->_em->getConnection()->prepare("
        SELECT
            u.id            AS id,
            u.firstname     AS firstname,
            u.lastname      AS lastname,
            u.username      AS username,
            u.picture_path  AS picture_path,
            COUNT(*)        AS upvote_total
        FROM
            post_vote AS pv
        LEFT JOIN
            post AS p ON p.id = pv.post_id
        LEFT JOIN
            user AS u ON u.id = p.user_id
        GROUP BY
            u.username
        ORDER BY
            COUNT(*) DESC
        LIMIT
            20
        ");

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
