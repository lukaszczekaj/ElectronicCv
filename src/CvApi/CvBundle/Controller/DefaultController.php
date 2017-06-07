<?php

namespace CvApi\CvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CvApiCvBundle:Default:index.html.twig');
    }
}
