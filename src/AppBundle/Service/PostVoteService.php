<?php

namespace AppBundle\Service;

use AppBundle\Entity\Post;
use AppBundle\Entity\PostVote;
use AppBundle\Entity\User;
use AppBundle\Repository\PostRepository;
use AppBundle\Repository\PostVoteRepository;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Exception\ServerException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Acl\Exception\Exception;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class PostVoteService extends AbstractService
{
    /**
     * @var PostVoteRepository
     */
    protected $repository;

    /**
     * @var PostRepository
     */
    protected $postRepository;

    public function __construct(
        PostVoteRepository $repository,
        PostRepository $postRepository
    ) {
        $this->repository     = $repository;
        $this->postRepository = $postRepository;
    }

    public function create(
        User $user,
        $postId
    ) {
        $post = $this->postRepository->find($postId);

        $postVote = new PostVote();

        $postVote->setPost($post);
        $postVote->setUser($user);
        $postVote->setCreatedAt(new \DateTime());

        $postVote = $this->repository->create($postVote);

        $this->postRepository->updateTotalVotes($post);

        return $postVote;
    }

    public function delete(
        User $user,
        $postId
    ) {
        $post = $this->postRepository->find($postId);

        $postVote = $this->repository->delete($user, $post);

        $this->postRepository->updateTotalVotes($post);

        return $postVote;
    }
}
