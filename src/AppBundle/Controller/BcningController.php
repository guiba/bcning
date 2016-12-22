<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class BcningController extends Controller
{

    /**
     * @Route("/stations/list", name="stations_list")
     */

    public function indexAction(Request $request)
    {
        $data = $this->get('bicing_api')->getStations();
        return $this->render('bcning/sations_list.html.twig', $data);
   }


    /**
     * @Route("/", name="full_map")
     */

    public function showFullMapAction(Request $request)
    {
        $data = $this->get('bicing_api')->getStations();
        return $this->render('bcning/full_map.html.twig', $data);
    }


    /**
     * @Route("/map/{stationId}", name="map")
     */

    public function showMapAction(Request $request, $stationId)
    {
        return $this->render('bcning/map.html.twig');
    }



    // api calls
    /**
     * @Route("/station/{stationId}", name="station")
     * Returns json details of the station (stationId)
     */

    public function jsonStationAction(Request $request, $stationId)
    {
        $station = $this->get('bicing_api')->getStation($stationId);
        $response = new JsonResponse();
        $response->setData($station);
        return $response;
    }

    /**
     * @Route("/stations", name="stations")
     * Returns json details of all stations
     */

    public function jsonStationsAction(Request $request)
    {
        $stations = $this->get('bicing_api')->getStations();
        $response = new JsonResponse();
        $response->setData($stations);
        return $response;
    }
}



