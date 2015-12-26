<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;
use AppBundle\Entity\PostVote;
use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class PostVoteRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function delete(
        User $user,
        Post $post
    ) {
        $conn = $this->_em->getConnection();

        $statement = $conn->prepare(
            'DELETE FROM post_vote WHERE user_id = :user_id AND post_id = :post_id'
        );

        $statement->bindValue('user_id', $user->getId());
        $statement->bindValue('post_id', $post->getId());

        return $statement->execute();
    }
}
