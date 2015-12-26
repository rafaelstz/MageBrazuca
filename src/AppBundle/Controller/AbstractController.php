<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Helper\UserHelper;
use AppBundle\Service\ServiceException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
abstract class AbstractController extends Controller
{
    /**
     * @return UserHelper
     */
    protected function getUserHelper()
    {
        return $this->get('mage_brazuca.user.helper');
    }
}
