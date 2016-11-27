<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class BcningController extends Controller
{
    /**
     * @Route("/bcning", name="bcning")
     */

    public function indexAction(Request $request)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://wservice.viabicing.cat/v2/stations');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);

// If using JSON...
        $data = json_decode($response, true);
        dump($data);
        return $this->render('bcning/index.html.twig', $data);
   }

    /**
     * @Route("stations", name="stations")
     */
    public function showStationsAction(Request $request)
    {

        return $this->render('bcning/stations.html.twig');
    }
}
