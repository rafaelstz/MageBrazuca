<?php

namespace AppBundle\Helper;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\UserService;
use Symfony\Component\Templating\Helper\Helper;
use Gaufrette\File;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class UserHelper extends Helper
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var User
     */
    private $loggedUser;

    public function __construct(
        Container $container,
        UserRepository $userRepository
    ) {
        $this->container      = $container;
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'userHelper';
    }

    public function isUserLogged()
    {
        return $this
            ->container
            ->get('request')
            ->getSession()
            ->has('user_id');
    }

    public function getLoggedUser()
    {
        if (!$this->isUserLogged()) {
            return false;
        }

        if (!$this->loggedUser) {
            $userId = $this
                ->container
                ->get('request')
                ->getSession()
                ->get('user_id');

            $this->loggedUser = $this
                ->userRepository
                ->find($userId);
        }

        return $this->loggedUser;
    }

    public function getImageStyleToHeader($picturePath)
    {
        return sprintf(
            'style="background: url(%s/user/image/%s-medium-1.%s) center center no-repeat;"',
            $this->container->getParameter('base_url'),
            $picturePath,
            UserService::USER_IMAGE_EXTENSION
        );
    }

    public function getImageStyleToTopDevelopers($picturePath)
    {
        return sprintf(
            'style="background: url(%s/user/image/%s-small.%s) center center no-repeat;"',
            $this->container->getParameter('base_url'),
            $picturePath,
            UserService::USER_IMAGE_EXTENSION
        );
    }

    public function getImageStyleToPostList($picturePath)
    {
        return sprintf(
            'style="background: url(%s/user/image/%s-small.%s) center center no-repeat;"',
            $this->container->getParameter('base_url'),
            $picturePath,
            UserService::USER_IMAGE_EXTENSION
        );
    }

    public function getImageToUserView($picturePath)
    {
        return sprintf(
            '/user/image/%s-medium-2.%s',
            $picturePath,
            UserService::USER_IMAGE_EXTENSION
        );
    }
}
