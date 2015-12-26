<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Service\ServiceException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class UserController extends AbstractController
{
    /**
     * ====================================
     * ====== GET METHODS
     * ====================================
     */

    /**
     * @Route("/user/create", methods={"GET"})
     */
    public function createGetAction()
    {
        return $this->render('AppBundle:User:create.html.php', array(
            'title' => 'Cadastro',
        ));
    }

    /**
     * @Route("/user/account", methods={"GET"})
     */
    public function editGetAction()
    {
        if (!$this->getUserHelper()->isUserLogged()) {
            return $this->redirect('/');
        }

        $user = $this->getUserHelper()->getLoggedUser();

        return $this->render('AppBundle:User:edit.html.php', array(
            'title' => 'Edição',
            'user'  => $user,
        ));
    }

    /**
     * @Route("/user/login", methods={"GET"})
     */
    public function loginGetAction()
    {
        return $this->render('AppBundle:User:login.html.php', array(
            'title' => 'Login',
        ));
    }

    /**
     * @Route("/user/logout", methods={"GET"})
     */
    public function logoutAction()
    {
        if (!$this->getUserHelper()->isUserLogged()) {
            return $this->redirect('/');
        }

        $this->get('mage_brazuca.user.service')->logout();

        $this->addFlash(
            'success',
            'Você foi deslogado com sucesso.'
        );

        return $this->redirect('/');
    }

    /**
     * @Route(
     *     path         = "/user/{username}",
     *     requirements = { "username" = "[\w.]+" },
     *     methods      = {"GET"}
     * )
     */
    public function viewAction($username)
    {
        try {
            $user = $this->get('mage_brazuca.user.service')->findByUsername($username);

            if (!$user) {
                return $this->render('AppBundle:User:view-not-found.html.php');
            }

            $posts = $this->get('mage_brazuca.post.service')->getToUserView($user);

            return $this->render('AppBundle:User:view.html.php', array(
                'title' => sprintf('Perfil de %s - %s', $user->getFullname(), $user->getUsername()),
                'user'  => $user,
                'posts' => $posts,
            ));
        } catch (\Exception $e) {
            $this->get('logger')->error(
                $e->getMessage()
            );

            $this->addFlash(
                'error',
                'Um erro ocorreu na visualização do usuário.'
            );

            return $this->redirect('/');
        }
    }

    /**
     * @Route("/user/my-posts/{page}", defaults={"page" = 1})
     */
    public function myPostsAction($page)
    {
        if (!$this->getUserHelper()->isUserLogged()) {
            return $this->redirect('/');
        }

        $postService = $this->get('mage_brazuca.post.service');

        $user = $this->getUserHelper()->getLoggedUser();

        $myPosts = $postService->getMyPosts($user, (int) $page);
        $maxPage = $postService->getMyPostsMaxPage($user);

        return $this->render('AppBundle:User:my-posts.html.php', array(
            'title'       => 'Todos Posts',
            'myPosts'     => $myPosts,
            'currentPage' => $page,
            'maxPage'     => $maxPage,
        ));
    }

    /**
     * ====================================
     * ====== POST METHODS
     * ====================================
     */

    /**
     * @Route("/user/create", methods={"POST"})
     */
    public function createPostAction(Request $request)
    {
        try {
            $userService = $this->get('mage_brazuca.user.service');

            $user = $userService->create(
                $request->request->get('firstname'),
                $request->request->get('lastname'),
                $request->request->get('email'),
                $request->request->get('username'),
                $request->request->get('password'),
                $request->request->get('about'),
                $request->files->get('picture'),
                $request->request->get('location'),
                $request->request->get('location_city_short'),
                $request->request->get('location_city_long'),
                $request->request->get('location_state_short'),
                $request->request->get('location_state_long'),
                $request->request->get('location_country_short'),
                $request->request->get('location_country_long'),
                $request->request->get('gender'),
                $request->request->get('company'),
                $request->request->get('is_available_to_hiring'),
                $request->request->get('contact_website'),
                $request->request->get('contact_twitter'),
                $request->request->get('contact_linkedin'),
                $request->request->get('contact_certification'),
                $request->request->get('contact_github'),
                $request->request->get('contact_stackoverflow')
            );

            $userService->login(
                $user->getUsername(),
                $user->getPassword(),
                true
            );

            $this->addFlash(
                'success',
                'Sua conta foi criada com sucesso! Aproveeeeeite!'
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

            print_r($e->getMessage());
            exit;

            return new JsonResponse(array(
                'error_system' => true,
            ));
        }
    }

    /**
     * @Route("/user/edit", methods={"POST"})
     */
    public function editPostAction(Request $request)
    {
        if (!$this->getUserHelper()->isUserLogged()) {
            $this->redirect('/');
        }

        $user = $this->getUserHelper()->getLoggedUser();

        try {
            $this->get('mage_brazuca.user.service')->update(
                $user,
                $request->request->get('firstname'),
                $request->request->get('lastname'),
                $request->request->get('email'),
                $request->request->get('username'),
                $request->request->get('password'),
                $request->request->get('about'),
                $request->files->get('picture'),
                $request->request->get('location'),
                $request->request->get('location_city_short'),
                $request->request->get('location_city_long'),
                $request->request->get('location_state_short'),
                $request->request->get('location_state_long'),
                $request->request->get('location_country_short'),
                $request->request->get('location_country_long'),
                $request->request->get('gender'),
                $request->request->get('company'),
                $request->request->get('is_available_to_hiring'),
                $request->request->get('contact_website'),
                $request->request->get('contact_twitter'),
                $request->request->get('contact_linkedin'),
                $request->request->get('contact_certification'),
                $request->request->get('contact_github'),
                $request->request->get('contact_stackoverflow')
            );

            $this->addFlash(
                'success',
                'Sua conta foi editada com sucesso! Volte sempre!'
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

            return new JsonResponse(array(
                'error_system' => true,
            ));
        }
    }

    /**
     * @Route("/user/login", methods={"POST"})
     */
    public function loginPostAction(Request $request) {
        try {
            if ($request->getSession()->get('user')) {
                return $this->redirect('/');
            }

            if (
                $this->get('mage_brazuca.user.service')->login(
                    $request->request->get('username'),
                    $request->request->get('password')
                )
            ) {
                $this->addFlash(
                    'success',
                    'Você se logou com sucesso! ;- D'
                );

                return $this->redirect('/');
            }

            $this->addFlash(
                'error',
                'Login e/ou senha incorretos. Tente novamente.'
            );

            return $this->redirect('/user/login');
        } catch (\Exception $e) {
            $this->get('logger')->error(
                $e->getMessage()
            );

            $this->addFlash(
                'error',
                'Um erro inesperado ocorreu. Por favor, tente mais tarde.'
            );

            return $this->redirect('/user/login');
        }
    }

//    //@TODO: MY ACCOUNT
//    /**
//     * @Route("/user/dashboard", methods={"GET"})
//     */
//    public function dashboardAction(Request $request)
//    {
//        $params = array(
//            'user_id' => $request->request->get('user_id'),
//        );
//
//        $em = $this->getDoctrine()->getManager();
//
//        $expressionList = $em
//            ->getRepository('AppBundle:Expression')
//            ->listUserDefault($params);
//
//        return $this->render('AppBundle:User:dashboard.html.php', array(
//            'expressionList' => $expressionList,
//        ));
//    }
}
