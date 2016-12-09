<?php

namespace AppBundle\Service;

class BicingApi
{

    private function fetchData()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://wservice.viabicing.cat/v2/stations');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        return $response;
    }

    private function geoJsonify($data)
    {
        //array with features
        $features = [];
        foreach ($data['stations'] as $index=>$station)
        {
                $feature = ['type' => 'Feature',
                    'properties' => [
                        'bikes' => $station['bikes'],
                        'slots' => $station['slots'],
                    ],
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            $station['latitude'],
                            $station['longitude']
                        ],
                    ],
                ];
                $features[] = $feature;
        }

        $geoJson = ['type' => 'FeatureCollection',
            'features' => $features];
//        $geoJson = ['type' => 'FeatureCollection',
//            'features' => [
//                ['type' => 'Feature',
//                    'properties' => [
//                        'bikes' => $data['bikes'],
//                        'slots' => $data['slots'],
//                    ],
//                    'geometry' => [
//                        'type' => 'Point',
//                        'coordinates' => [
//                            $data['latitude'],
//                            $data['longitude']
//                        ],
//                    ],
//
//                ],
//            ]];
        return $geoJson;
    }

    public function getStations()
    {
        $response = $this->fetchData();

// If using JSON...
        $data = json_decode($response, true);
//        $data['tot_stations'] = 0;
//        $data['tot_slots'] = 0;
//        $data['tot_bikes'] = 0;
////  A bit of stats
//        foreach ($data['stations'] as $station) {
//            $data['tot_stations'] += 1;
//            $data['tot_slots'] += $station['slots'];
//            $data['tot_bikes'] += $station['bikes'];
//
//        }
        return $this->geoJsonify($data);
    }

    public function getStation($stationId)
    {
        $api_response = $this->fetchData();
        $data = json_decode($api_response, true);
        $station = $data['stations'][$stationId - 1];
        return $this->geoJsonify($station);
    }
}