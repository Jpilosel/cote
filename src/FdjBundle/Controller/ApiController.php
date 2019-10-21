<?php

namespace FdjBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ApiController extends Controller
{
    public function indexAction($name)
    {

        return $this->render('', array('name' => $name));
    }
}
