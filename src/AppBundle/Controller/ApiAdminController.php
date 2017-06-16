<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use AppBundle\Entity\User;
use AppBundle\Entity\Education;
use AppBundle\Entity\Workplace;
use AppBundle\Entity\AdditionalSkills;
use AppBundle\Entity\Languages;
use AppBundle\Entity\Cv;
use AppBundle\Entity\EducationCv;
use AppBundle\Entity\Approle;

/**
 * Description of ApiController
 *
 * @author lukasz
 */
class ApiAdminController extends FOSRestController {

    /**
     * @Rest\Get("/admin-list-users/{token}")
     */
    public function getAdminListUsersAction($token) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $adminRole = $em->getRepository('AppBundle:Approle')->findOneBy(array('rolename' => 'admin'));
        if ($adminRole->getId() != $existUser->getApproleid()) {
            return new Response("API: Brak uprawnień", Response::HTTP_FORBIDDEN);
        }
        $return = $em->getRepository('AppBundle:User')->findAll();
        return $return;
    }

    private function getElementFromArrayByKeyName($array, $keyName, $keyValue) {
        if (!is_array($array)) {
            throw new Exception('To nie tablica');
        }
        foreach ($array as $value) {
            if ($value[$keyName] == $keyValue) {
                return $value;
            }
        }
        throw new Exception('Brak takiego rekordu');
    }

    /**
     * @Rest\Post("/admin-action/")
     */
    public function addAddtionalSkillsAction(Request $request) {
        $token = $request->get('authToken');
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $adminRole = $em->getRepository('AppBundle:Approle')->findOneBy(array('rolename' => 'admin'));
        if ($adminRole->getId() != $existUser->getApproleid()) {
            return new Response("API: Brak uprawnień", Response::HTTP_FORBIDDEN);
        }
        $data = $request->request->all();

        if (!isset($data['action']) || empty($data['action'])) {
            return new Response("API: Brak przesłanej nazwy akcji", Response::HTTP_NOT_FOUND);
        }

        switch ($data['action']) {
            case 'user-activate':
                $user = $em->getRepository('AppBundle:User')->find($data['id']);
                if (!$user) {
                    return new Response("API: Niepowodzenie pobrania uzytkownika", Response::HTTP_NOT_ACCEPTABLE);
                }
                $user->setStatus(1);
                $em->persist($user);
                $em->flush();
                $msg = 'Użytkownik aktywowany';
                break;
            case 'user-deactivate':
                $user = $em->getRepository('AppBundle:User')->find($data['id']);
                if (!$user) {
                    return new Response("API: Niepowodzenie pobrania uzytkownika", Response::HTTP_NOT_ACCEPTABLE);
                }
                $user->setStatus(0);
                $em->persist($user);
                $em->flush();
                $msg = 'Użytkownik dezaktywowany';
                break;
            default:
                return new Response("API: Akcja nieobsługiwana", Response::HTTP_NOT_FOUND);
        }

        return new Response('API: ' . $msg, Response::HTTP_OK);
    }

}
