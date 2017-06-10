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
        $restresult = array('aaa' => 'asdasd');
        return $restresult;
    }

    /**
     * @Rest\Post("/register-user/")
     */
    public function postAction(Request $request) {
        $name = $request->get('name');
        $role = $request->get('role');
        if (empty($name) || empty($role)) {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        return new View("User Added Successfully", Response::HTTP_OK);
    }

}


//$user = new User;
//        $mail = $request->get('mail');
//        $pass = $request->get('pass');
//        $retypePass = $request->get('retype-password');
//        if (empty($mail) || empty($pass) || empty($retypePass)) {
//            return new View("Brak kompletnych danych", Response::HTTP_NOT_ACCEPTABLE);
//        }
//        if ($pass !== $retypePass) {
//            return new View("Hasła nie są identyczne", Response::HTTP_NOT_ACCEPTABLE);
//        }
//        $user->setMail($mail);
//        $user->setPass(hash('sha256', $pass));
//        $em = $this->getDoctrine()->getManager();
//        try {
//            $em->persist($user);
//            $em->flush();
//        } catch (Exception $exc) {
//            return new View($exc->getMessage, Response::HTTP_INTERNAL_SERVER_ERROR);
//        }
//        return new View("Zarejestrowano poprawnie", Response::HTTP_OK);