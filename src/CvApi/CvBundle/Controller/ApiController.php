<?php

namespace CvApi\CvBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class ApiController extends FOSRestController {

    public function optionsAction() {
        
    }
    
    public function getAction() {
        $data = [];
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }

    public function getTestAction() {
        $data = [
            'type' => 'Spicy',
            'quantity' => '30ml',
        ];
        $view = $this->view($data, 200);
        return $this->handleView($view);
    }
    
}
