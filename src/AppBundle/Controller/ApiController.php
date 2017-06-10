<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

/**
 * Description of ApiController
 *
 * @author lukasz
 */
class ApiController extends FOSRestController {

    /**
     * @Rest\Get("/aaa")
     */
    public function getAction() {
        $restresult = array('aaa' => 'j');
        return $restresult;
    }

    /**
     * @Rest\Post("/user/")
     */
    public function postAction(Request $request) {
        $name = $request->get('name');
        if (empty($name)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        return new View("User Added Successfully", Response::HTTP_OK);
    }

}
