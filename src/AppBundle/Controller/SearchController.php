<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;
use AppBundle\Service\ServiceException;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends AbstractController
{
    /**
     * @Route(
     *     path         = "/search/{searchQuery}/{page}",
     *     requirements = {"query" = "[\w-]+"},
     *     defaults     = {"page" = 1},
     *     methods      = {"GET"}
     * )
     */
    public function indexAction($searchQuery, $page)
    {
        $postService = $this->get('mage_brazuca.post.service');

        $allPosts = $postService->getBySearchQuery($searchQuery, (int) $page);
        $maxPage  = $postService->getBySearchQueryMaxPage($searchQuery);

        $topDevelopers = $this->get('mage_brazuca.user.service')->getTop();

        return $this->render('AppBundle:Search:index.html.php', array(
            'title'         => sprintf('Busca do termo "%s', $searchQuery),
            'searchQuery'   => $searchQuery,
            'allPosts'      => $allPosts,
            'topDevelopers' => $topDevelopers,
            'currentPage'   => $page,
            'maxPage'       => $maxPage,
        ));
    }
}
