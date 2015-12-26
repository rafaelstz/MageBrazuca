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
class PostController extends AbstractController
{
    /**
     * ====================================
     * ====== GET METHODS
     * ====================================
     */

    /**
     * @Route("/post/all/{page}", defaults={"page" = 1})
     */
    public function allAction($page)
    {
        $postService = $this->get('mage_brazuca.post.service');

        $allPosts = $postService->getAll((int) $page);
        $maxPage  = $postService->getAllMaxPage();

        $topDevelopers = $this->get('mage_brazuca.user.service')->getTop();

        return $this->render('AppBundle:Post:all.html.php', array(
            'title'         => 'Todos Posts',
            'allPosts'      => $allPosts,
            'topDevelopers' => $topDevelopers,
            'currentPage'   => $page,
            'maxPage'       => $maxPage,
        ));
    }

    /**
     * @Route("/post/create", methods={"GET"})
     */
    public function createGetAction()
    {
        if (!$this->getUserHelper()->isUserLogged()) {
            return $this->redirect('/');
        }

        return $this->render('AppBundle:Post:create.html.php', array(
            'title' => 'Novo Post',
        ));
    }

    /**
     * @Route(
     *     path         = "/post/delete/{id}",
     *     requirements = {"id" = "\d+"},
     *     methods      = {"GET"}
     * )
     */
    public function deleteAction($id)
    {
        if (!$this->getUserHelper()->isUserLogged()) {
            return $this->redirect('/');
        }

        $user = $this->getUserHelper()->getLoggedUser();

        $this->get('mage_brazuca.post.service')->myPostsDelete($id, $user);

        $this->addFlash(
            'success',
            'Post deletado com sucesso.'
        );

        return $this->redirect('/user/my-posts');
    }

    /**
     * ====================================
     * ====== POST METHODS
     * ====================================
     */

    /**
     * @Route("/post/create", methods={"POST"})
     */
    public function createPostAction(Request $request)
    {
        try {
            $postService = $this->get('mage_brazuca.post.service');

            if (!$this->getUserHelper()->isUserLogged()) {
                return $this->redirect('/');
            }

            $user = $this->getUserHelper()->getLoggedUser();

            $postService->create(
                $user,
                $request->request->get('title'),
                $request->request->get('url'),
                $request->request->get('tag')
            );

            $this->addFlash(
                'success',
                'Post adicionado com sucesso!'
            );

            return new JsonResponse(array(
                'success' => true,
            ));
        } catch (ServiceException $e) {
            return new JsonResponse(array(
                'error'  => true,
                'errors' => $e->getErrors(),
            ));
        } catch (\Exception $e) {
            $this->get('logger')->error(
                $e->getMessage()
            );

            $this->addFlash(
                'error',
                'Um erro inesperado ocorreu na criação do post. Tente novamente.'
            );

            return new JsonResponse(array(
                'error_system' => true,
            ));
        }
    }
}
