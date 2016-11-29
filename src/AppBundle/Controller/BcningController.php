<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


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
        $data['tot_stations'] = 0;
        $data['tot_slots'] = 0;
        $data['tot_bikes'] = 0;
//  A bit of stats
        foreach ($data['stations'] as $station)
        {
            $data['tot_stations'] += 1;
            $data['tot_slots'] += $station['slots'];
            $data['tot_bikes'] += $station['bikes'];

        }

//        dump($data);
        return $this->render('bcning/index.html.twig', $data);
   }

    /**
     * @Route("/stations", name="stations")
     */
    public function showStationsAction(Request $request)
    {

        return $this->render('bcning/stations.html.twig');
    }

    /**
     * @Route("station/{stationId}", name="station")
     * Returns json details of the station (stationId)
     */

    public function jsonStationAction(Request $request, $stationId)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://wservice.viabicing.cat/v2/stations');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $api_response = curl_exec($ch);
        $data = json_decode($api_response, true);
        $station = $data['stations'][$stationId-1];
        $response = new JsonResponse();
        $response->setData($station);
        return $response;
//        return $this->render('bcning/map.html.twig', $station);

    }


    /**
     * @Route("map/{stationId}", name="map")
     */

    public function showMapAction(Request $request, $stationId)
    {
        return $this->render('bcning/map.html.twig');
    }
}
