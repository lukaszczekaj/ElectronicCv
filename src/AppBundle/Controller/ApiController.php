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
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $existUser = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(array('mail' => $mail));
        if ($existUser) {
            return new Response("API: Taki e-mail już istnieje w bazie", Response::HTTP_NOT_ACCEPTABLE);
        }
        if ($pass !== $retypePass) {
            return new Response("API: Hasła nie są identyczne", Response::HTTP_NOT_ACCEPTABLE);
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
            return new Response($exc->getMessage, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new Response("API: Zarejestrowano poprawnie", Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/login/")
     */
    public function loginUserAction(Request $request) {
        $mail = $request->get('mail');
        $pass = $request->get('password');
        if (empty($mail) || empty($pass)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('mail' => $mail));
        if (!$existUser) {
            return new Response("API: Niepoprawne dane logowania", Response::HTTP_NOT_ACCEPTABLE);
        }
        if (!$existUser->getStatus()) {
            return new Response("API: Konto jest nieaktywne", Response::HTTP_NOT_ACCEPTABLE);
        }
        if ($existUser->getPass() !== hash('sha256', $pass)) {
            return new Response("API: Niepoprawne dane logowania", Response::HTTP_NOT_ACCEPTABLE);
        }

        $existUser->setAuthtoken(md5(uniqid()));
        $em->flush();

        //  $repository->flush();
        $response = array(
            'msg' => 'Zarejestrowano poprawnie',
            'authToken' => $existUser->getAuthtoken(),
            'name' => sprintf('%s %s', $existUser->getFirstname(), $existUser->getLastname()),
            'profilePicture' => $existUser->getImage(),
            'id' => $existUser->getId(),
        );
        return new Response(json_encode($response), Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/update-profile/")
     */
    public function updateUserProfileAction(Request $request) {
        $token = $request->get('authToken');
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $data = $request->request->all();
        if (isset($data['firstName']) && !empty($data['firstName'])) {
            $existUser->setFirstname($data['firstName']);
        }
        if (isset($data['lastName']) && !empty($data['lastName'])) {
            $existUser->setLastname($data['lastName']);
        }
        if (isset($data['birthDate']) && !empty($data['birthDate'])) {
            $existUser->setBirthdate(\DateTime::createFromFormat("m/d/Y", $data['birthDate']));
        }
        if (isset($data['birthPlace']) && !empty($data['birthPlace'])) {
            $existUser->setBirthplace($data['birthPlace']);
        }
        if (isset($data['addressStreet']) && !empty($data['addressStreet'])) {
            $existUser->setAddressstreet($data['addressStreet']);
        }
        if (isset($data['addressPost']) && !empty($data['addressPost'])) {
            $existUser->setAddresspost($data['addressPost']);
        }
        if (isset($data['maritalStatus']) && !empty($data['maritalStatus'])) {
            $existUser->setMaritalstatus($data['maritalStatus']);
        }
        if (isset($data['phone']) && !empty($data['phone'])) {
            $existUser->setPhone($data['phone']);
        }
        if (isset($data['image']) && !empty($data['image'])) {
            $existUser->setImage($data['image']);
        }
        $em->flush();
        return new Response('API: Zapisano zmiany', Response::HTTP_OK);
    }

    private function getUserByAuthToken($token) {
        $em = $this->getDoctrine()->getEntityManager();
        return $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
    }

    /**
     * @Rest\Get("/user-data/{token}")
     */
    public function getUserDataAction($token, Request $request) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $existUser = $this->getUserByAuthToken($token);
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $existUser->setPass(null);
        $em = $this->getDoctrine()->getEntityManager();
        $userInfo = array(
            'countCv' => sizeof($em->getRepository('AppBundle:Cv')->findBy(array('userid' => $existUser->getId()))),
            'countEducation' => sizeof($em->getRepository('AppBundle:Education')->findBy(array('userid' => $existUser->getId()))),
            'countLanguages' => sizeof($em->getRepository('AppBundle:Languages')->findBy(array('userid' => $existUser->getId()))),
            'countWorkplace' => sizeof($em->getRepository('AppBundle:Workplace')->findBy(array('userid' => $existUser->getId()))),
            'countAdditionalSkills' => sizeof($em->getRepository('AppBundle:AdditionalSkills')->findBy(array('userid' => $existUser->getId())))
        );


        return array('user' => $existUser, 'userInfo' => $userInfo);
    }

    /**
     * @Rest\Post("/change-pass/")
     */
    public function changeUserPassAction(Request $request) {
        $token = $request->get('authToken');
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }

        $data = $request->request->all();
        if ($existUser->getPass() !== hash('sha256', $data['passwordActual'])) {
            return new Response("API: Obecne hasło jest błędne", Response::HTTP_NOT_ACCEPTABLE);
        }
        if ($data['password'] !== $data['passwordAgain']) {
            return new Response("API: Nowe hasła nie sa identyczne", Response::HTTP_NOT_ACCEPTABLE);
        }
        $existUser->setPass(hash('sha256', $data['password']));
        $em->flush();
        return new Response('API: Hasło zmienione', Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/add-cv/")
     */
    public function addCvAction(Request $request) {
        $token = $request->get('authToken');
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $data = $request->request->all();

        $cv = new Cv();
        $cv->setName($data['name']);
        $cv->setInterests($data['interests']);
        $cv->setPdfLayout($data['layoutID']);
        $cv->setUserid($existUser->getId());
        if (isset($data['education'])) {
            $cv->setListEducation($data['education']);
        }
        if (isset($data['workplace'])) {
            $cv->setListWorkplace($data['workplace']);
        }
        if (isset($data['additionalSkills'])) {
            $cv->setListAdditionalSkills($data['additionalSkills']);
        }
        if (isset($data['languages'])) {
            $cv->setListLanguages($data['languages']);
        }

        $em->persist($cv);
        $em->flush();
        return new Response('API: Zapisano nowe CV ', Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/add-education/")
     */
    public function addEducationAction(Request $request) {
        $token = $request->get('authToken');
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $data = $request->request->all();

        $education = new Education();
        $education->setDescription($data['description']);
        $education->setUserid($existUser->getId());
        if (isset($data['date_of']) && !empty($data['date_of'])) {
            $education->setDateOf(\DateTime::createFromFormat("m/d/Y", $data['date_of']));
        }
        if (isset($data['date_to']) && !empty($data['date_to'])) {
            $education->setDateTo(\DateTime::createFromFormat("m/d/Y", $data['date_to']));
        }
        $em->persist($education);
        $em->flush();
        return new Response('API: Dodano wykrztałcenie ', Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/add-workplace/")
     */
    public function addWorkplaceAction(Request $request) {
        $token = $request->get('authToken');
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $data = $request->request->all();

        $workplace = new Workplace();
        $workplace->setDescription($data['description']);
        $workplace->setUserid($existUser->getId());
        if (isset($data['date_of']) && !empty($data['date_of'])) {
            $workplace->setDateOf(\DateTime::createFromFormat("m/d/Y", $data['date_of']));
        }
        if (isset($data['date_to']) && !empty($data['date_to'])) {
            $workplace->setDateTo(\DateTime::createFromFormat("m/d/Y", $data['date_to']));
        }
        $em->persist($workplace);
        $em->flush();
        return new Response('API: Dodano miejsce pracy ', Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/add-languages/")
     */
    public function addLanguagesAction(Request $request) {
        $token = $request->get('authToken');
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $data = $request->request->all();

        $languages = new Languages();
        $languages->setDescription($data['description']);
        $languages->setName($data['name']);
        $languages->setUserid($existUser->getId());
        $em->persist($languages);
        $em->flush();
        return new Response('API: Dodano język ', Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/add-additional-skills/")
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
        $data = $request->request->all();

        $additionalSkills = new AdditionalSkills();
        $additionalSkills->setDescription($data['description']);
        $additionalSkills->setUserid($existUser->getId());
        if (isset($data['date']) && !empty($data['date'])) {
            $additionalSkills->setDate(\DateTime::createFromFormat("m/d/Y", $data['date']));
        }
        $em->persist($additionalSkills);
        $em->flush();
        return new Response('API: Dodano dodatkową umiejętność ', Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/list-education/{token}")
     */
    public function getUserEducationAction($token) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $allEducation = $em->getRepository('AppBundle:Education')->findBy(array('userid' => $existUser->getId()));
        return $allEducation;
    }

    /**
     * @Rest\Get("/list-cv/{token}")
     */
    public function getUserCvsAction($token) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $return = $em->getRepository('AppBundle:Cv')->findBy(array('userid' => $existUser->getId()));
        return $return;
    }

    /**
     * @Rest\Get("/get-cv/{token}/{id}")
     */
    public function getUserCvAction($token, $id) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $row = $em->getRepository('AppBundle:Cv')->find($id);
        if (empty($row)) {
            return new Response("API: Brak danych", Response::HTTP_NOT_FOUND);
        }
        if ($row->getUserid() !== $existUser->getId()) {
            return new Response("API: Brak uprawnień", Response::HTTP_UNAUTHORIZED);
        }
        return $row;
    }

    /**
     * @Rest\Get("/list-languages/{token}")
     */
    public function getUserLanguagesAction($token) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $return = $em->getRepository('AppBundle:Languages')->findBy(array('userid' => $existUser->getId()));
        return $return;
    }

    /**
     * @Rest\Get("/list-additional-skills/{token}")
     */
    public function getUserAdditionalSkillsAction($token) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $return = $em->getRepository('AppBundle:AdditionalSkills')->findBy(array('userid' => $existUser->getId()));
        return $return;
    }

    /**
     * @Rest\Get("/list-app-roles/{token}")
     */
    public function getApproleAction($token) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $return = $em->getRepository('AppBundle:Approle')->findAll();
        return $return;
    }

    /**
     * @Rest\Get("/list-workplace/{token}")
     */
    public function getUserWorkplaceAction($token) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $return = $em->getRepository('AppBundle:Workplace')->findBy(array('userid' => $existUser->getId()));
        return $return;
    }

    /**
     * @Rest\Delete("/remove-education/{token}/{id}")
     */
    public function deleteEducationAction($token, $id) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }

        $row = $em->getRepository('AppBundle:Education')->find($id);

        if (empty($row)) {
            return new Response("API: Brak danych", Response::HTTP_NOT_FOUND);
        }
        if ($row->getUserid() !== $existUser->getId()) {
            return new Response("API: Brak uprawnień", Response::HTTP_UNAUTHORIZED);
        }
        $em->remove($row);
        $em->flush();
        return new Response("Wykrztałcenie usunięte");
    }

    /**
     * @Rest\Delete("/remove-cv/{token}/{id}")
     */
    public function deleteCvAction($token, $id) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }

        $row = $em->getRepository('AppBundle:Cv')->find($id);

        if (empty($row)) {
            return new Response("API: Brak danych", Response::HTTP_NOT_FOUND);
        }
        if ($row->getUserid() !== $existUser->getId()) {
            return new Response("API: Brak uprawnień", Response::HTTP_UNAUTHORIZED);
        }
        $em->remove($row);
        $em->flush();
        return new Response("Cv usunięte");
    }

    /**
     * @Rest\Delete("/remove-workplace/{token}/{id}")
     */
    public function deleteWorkplaceAction($token, $id) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }

        $row = $em->getRepository('AppBundle:Workplace')->find($id);

        if (empty($row)) {
            return new Response("API: Brak danych", Response::HTTP_NOT_FOUND);
        }
        if ($row->getUserid() !== $existUser->getId()) {
            return new Response("API: Brak uprawnień", Response::HTTP_UNAUTHORIZED);
        }
        $em->remove($row);
        $em->flush();
        return new Response("Miejsce pracy usunięte");
    }

    /**
     * @Rest\Delete("/remove-languages/{token}/{id}")
     */
    public function deleteLanguagesAction($token, $id) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }

        $row = $em->getRepository('AppBundle:Languages')->find($id);

        if (empty($row)) {
            return new Response("API: Brak danych", Response::HTTP_NOT_FOUND);
        }
        if ($row->getUserid() !== $existUser->getId()) {
            return new Response("API: Brak uprawnień", Response::HTTP_UNAUTHORIZED);
        }
        $em->remove($row);
        $em->flush();
        return new Response("Miejsce pracy usunięte");
    }

    /**
     * @Rest\Delete("/remove-additional-skills/{token}/{id}")
     */
    public function deleteAdditionalSkillsAction($token, $id) {
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $existUser = $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
        if (!$existUser) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }

        $row = $em->getRepository('AppBundle:AdditionalSkills')->find($id);

        if (empty($row)) {
            return new Response("Brak danych", Response::HTTP_NOT_FOUND);
        }
        if ($row->getUserid() !== $existUser->getId()) {
            return new Response("API: Brak uprawnień", Response::HTTP_UNAUTHORIZED);
        }
        $em->remove($row);
        $em->flush();
        return new Response("Dodatkowa umiejętność usunięta");
    }

}
