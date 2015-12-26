<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PostVote;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class PostVoteController extends AbstractController
{
    /**
     * @Route("/post-vote/create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        if (!$this->getUserHelper()->isUserLogged()) {
            exit;
        }

        $this->get('mage_brazuca.post_vote.service')->create(
            $this->getUserHelper()->getLoggedUser(),
            $request->request->get('post_id')
        );

        return new JsonResponse(array(
            'success' => true,
        ));
    }

    /**
     * @Route("/post-vote/delete", methods={"POST"})
     */
    public function deleteAction(Request $request)
    {
        if (!$this->getUserHelper()->isUserLogged()) {
            exit;
        }

        $this->get('mage_brazuca.post_vote.service')->delete(
            $this->getUserHelper()->getLoggedUser(),
            $request->request->get('post_id')
        );

        return new JsonResponse(array(
            'success' => true,
        ));
    }
}
