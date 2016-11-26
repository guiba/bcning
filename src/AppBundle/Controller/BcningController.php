<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class BcningController extends Controller
{
    /**
     * @Route("/bcning", name="bcning")
     */

    public function indexAction($name)
    {
        return $this->render('bcning/index.html.twig');
    }
}
