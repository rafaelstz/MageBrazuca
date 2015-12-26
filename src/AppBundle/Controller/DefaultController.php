<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        $postService = $this->get('mage_brazuca.post.service');
        $userService = $this->get('mage_brazuca.user.service');

        $mostVotedOfTheWeek  = $postService->getMostVotedOfTheWeek();
        $topDevelopers       = $userService->getTop();

        return $this->render('AppBundle:Page:index.html.php', array(
            'title'              => 'Comunidade Magento do Brasil: Os melhores desenvolvedores estão aqui!',
            'mostVotedOfTheWeek' => $mostVotedOfTheWeek,
            'topDevelopers'      => $topDevelopers,
        ));
    }

    public function pageNotFoundAction()
    {
        return $this->render('AppBundle:Page:page-not-found.html.php');
    }
}
