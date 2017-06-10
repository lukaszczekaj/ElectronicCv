<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

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
    public function registerUserAction(Request $request) {
        $user = new User;
        $mail = $request->get('mail');
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $pass = $request->get('password');
        $retypePass = $request->get('retype-password');
        if (empty($mail) || empty($pass) || empty($retypePass) || empty($firstName) || empty($lastName)) {
            return new View("API: Brak kompletnych danych " . json_encode($mail), Response::HTTP_NOT_ACCEPTABLE);
        }
        $existUser = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('mail' => $mail));
        if ($existUser) {
            return new View("API: Taki e-mail już istnieje w bazie", Response::HTTP_NOT_ACCEPTABLE);
        }
        if ($pass !== $retypePass) {
            return new View("API: Hasła nie są identyczne", Response::HTTP_NOT_ACCEPTABLE);
        }
        $user->setMail($mail);
        $user->setFirstname($firstName);
        $user->setLastname($lastName);
        $user->setPass(hash('sha256', $pass));
        $em = $this->getDoctrine()->getManager();
        try {
            $em->persist($user);
            $em->flush();
        } catch (Exception $exc) {
            return new View($exc->getMessage, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new View("Zarejestrowano poprawnie", Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/login/")
     */
    public function loginUserAction(Request $request) {
        $mail = $request->get('mail');
        $pass = $request->get('password');
        if (empty($mail) || empty($pass)) {
            return new View("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('mail' => $mail));
        if (!$existUser) {
            return new View("API: Niepoprawne dane logowania", Response::HTTP_NOT_ACCEPTABLE);
        }

        if ($existUser->getPass() !== hash('sha256', $pass)) {
            return new View("API: Niepoprawne dane logowania", Response::HTTP_NOT_ACCEPTABLE);
        }

        $existUser->setAuthtoken(md5(uniqid()));
        $em->flush();

        //  $repository->flush();
        $response = array(
            'msg' => 'Zarejestrowano poprawnie',
            'authToken' => $existUser->getAuthtoken(),
            'name' => sprintf('%s %s', $existUser->getFirstname(), $existUser->getLastname())
        );
        return new View(json_encode($response), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/update-profile/")
     */
    public function updateUserProfileAction(Request $request) {
        $token = $request->get('authToken');
        if (empty($token)) {
            return new View("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $existUser = $this->getUserByAuthToken($token);
        if (!$existUser) {
            return new View("API: Niepoprawna identyfikacja", Response::HTTP_NOT_ACCEPTABLE);
        }
        return new View('API: Zapisano', Response::HTTP_OK);
    }

    private function getUserByAuthToken($token) {
        $em = $this->getDoctrine()->getEntityManager();
        return $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
    }

}
