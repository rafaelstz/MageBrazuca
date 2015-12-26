<?php

namespace AppBundle\Service;

use AppBundle\Entity\Post;
use AppBundle\Entity\User;
use AppBundle\Repository\PostRepository;
use Doctrine\DBAL\Exception\ServerException;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class PostService extends AbstractService
{
    const ALL_POST_LIMIT = 50;

    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * @var Validator
     */
    private $validator;

    public function __construct(
        PostRepository $repository,
        ValidatorInterface $validator
    ) {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    public function create(
        User $user,
        $title,
        $url,
        $tag
    ) {

        if (
            $errors = $this->getErrors(
                $title,
                $url,
                $tag
            )
        ) {
            throw new ServiceException($errors);
        }

        $post = new Post();

        $post->setUser($user);
        $post->setTitle($title);
        $post->setUrl($url);
        $post->setTag($this->formatTag($tag));
        $post->setUpvoteTotal(0);
        $post->setCreatedAt(new \DateTime);

        return $this->repository->create($post);
    }

    public function getErrors(
        $title,
        $url,
        $tag
    ) {
        $validator = $this->validator;

        $errors = array();

        $titleValidation = $validator->validateValue($title, array(
            new Constraints\NotBlank(),
            new Constraints\Length(array(
                'min' => 10,
                'max' => 140,
            )),
        ));

        if ($titleValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo de Título';
        }

        $urlValidation = $validator->validateValue($url, array(
            new Constraints\NotBlank(),
            new Constraints\Length(array(
                'min' => 10,
            )),
        ));

        if ($urlValidation->count()) {
            $errors[] = 'Por favor, digite corretamente o campo de URL';
        }

        $tagValidation = $validator->validateValue($tag, array(
            new Constraints\NotBlank(),
            new Constraints\Length(array(
                'min' => 5,
            )),
        ));

        if (
               $tagValidation->count()
            && !$this->isTagValid($tag)
        ) {
            $errors[] = 'Por favor, digite corretamente o campo de Tag';
        }

        if ($errors) {
            return $errors;
        }

        return false;
    }

    private function isTagValid($tag)
    {
        $tagExploded = explode(',', $tag);

        foreach ($tagExploded as $tag) {
            $tag = trim($tag);

            if (!preg_match('/^[\w-]+$/', $tag)) {
                return false;
            }
        }

        return true;
    }

    private function formatTag($tag)
    {
        $tagExploded = explode(',', $tag);

        $tags = array();

        foreach ($tagExploded as $tag) {
            $tag = trim($tag);
            $tag = strtolower($tag);

            $tags[] = $tag;
        }

        return implode(', ', $tags);
    }

    /**
     * @param User $user
     * @return array
     */
    public function getToUserView(User $user)
    {
        return $this->repository->getToUserView($user);
    }

    /**
     * @return array
     */
    public function getMostVotedOfTheWeek()
    {
        return $this->repository->getMostVotedOfTheWeek();
    }

    /**
     * @param int $page
     * @return object
     */
    public function getAll($page)
    {
        $offset = (($page - 1) * self::ALL_POST_LIMIT);

        return $this->repository->getAll($offset, self::ALL_POST_LIMIT);
    }

    /**
     * @return int
     */
    public function getAllMaxPage()
    {
        $count = $this->repository->getAllCount();

        $maxPage = ceil($count / self::ALL_POST_LIMIT);

        return $maxPage;
    }

    /**
     * @param int $page
     * @return object
     */
    public function getMyPosts(User $user, $page)
    {
        $offset = (($page - 1) * self::ALL_POST_LIMIT);

        return $this->repository->getMyPosts($user, $offset, self::ALL_POST_LIMIT);
    }

    /**
     * @return int
     */
    public function getMyPostsMaxPage(User $user)
    {
        $count = $this->repository->getMyPostsCount($user);

        $maxPage = ceil($count / self::ALL_POST_LIMIT);

        return $maxPage;
    }

    /**
     * @param int $page
     * @return object
     */
    public function getByTag($tag, $page)
    {
        $offset = (($page - 1) * self::ALL_POST_LIMIT);

        return $this->repository->getByTag($tag, $offset, self::ALL_POST_LIMIT);
    }

    /**
     * @return int
     */
    public function getByTagMaxPage($tag)
    {
        $count = $this->repository->getByTagCount($tag);

        $maxPage = ceil($count / self::ALL_POST_LIMIT);

        return $maxPage;
    }

    /**
     * @param int $page
     * @return object
     */
    public function getBySearchQuery($searchQuery, $page)
    {
        $offset = (($page - 1) * self::ALL_POST_LIMIT);

        return $this->repository->getBySearchQuery($searchQuery, $offset, self::ALL_POST_LIMIT);
    }

    /**
     * @return int
     */
    public function getBySearchQueryMaxPage($searchQuery)
    {
        $count = $this->repository->getBySearchQueryCount($searchQuery);

        $maxPage = ceil($count / self::ALL_POST_LIMIT);

        return $maxPage;
    }

    /**
     * @return bool
     */
    public function myPostsDelete($id, User $user)
    {
        $post = $this->repository->find($id);

        if (
               !$post
            || $post->getUser()->getId() != $user->getId()) {
            return false;
        }

        return $this->repository->delete($post);
    }
}
