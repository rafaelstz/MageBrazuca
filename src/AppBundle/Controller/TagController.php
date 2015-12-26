<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use AppBundle\Service\ServiceException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class TagController extends AbstractController
{
    /**
     * @Route(
     *     path         = "/tag/{tag}/{page}",
     *     requirements = {"tag" = "[\w-]+"},
     *     defaults     = {"page" = 1},
     *     methods      = {"GET"}
     * )
     */
    public function indexAction($tag, $page)
    {
        $postService = $this->get('mage_brazuca.post.service');

        $allPosts = $postService->getByTag($tag, (int) $page);
        $maxPage  = $postService->getByTagMaxPage($tag);

        $topDevelopers = $this->get('mage_brazuca.user.service')->getTop();

        return $this->render('AppBundle:Tag:index.html.php', array(
            'title'         => sprintf('Tag "%s"', $tag),
            'tag'           => $tag,
            'allPosts'      => $allPosts,
            'topDevelopers' => $topDevelopers,
            'currentPage'   => $page,
            'maxPage'       => $maxPage,
        ));
    }
}
