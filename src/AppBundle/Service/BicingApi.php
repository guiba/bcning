<?php

namespace AppBundle\Service;

class BicingApi
{
    public function getStations()
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
        return $data;
    }

    public function getStation($stationId)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://wservice.viabicing.cat/v2/stations');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $api_response = curl_exec($ch);
        $data = json_decode($api_response, true);
        $station = $data['stations'][$stationId-1];
        return $station;
    }
}