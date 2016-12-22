<?php

namespace AppBundle\Service;


class BicingApi
{

    /**
     * @return json
     *
     */
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
                        'id'    =>  $station['id'],
                        'bikes' => $station['bikes'],
                        'slots' => $station['slots'],
                        'streetName' => $station['streetName'],
                        'streetNumber' => $station['streetNumber'],
                        'type' => $station['type'],
                        'status' => $station['status'],
                        'nearbyStations' => $station['nearbyStations']
                    ],
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            $station['longitude'],
                            $station['latitude']
                        ],
                    ],
                ];
                $features[] = $feature;
        }

        $geoJson = ['type' => 'FeatureCollection',
                    'features' => $features,
                    ];

        return $geoJson;
    }

    /**
     * @return array
     * Returns stations data in geojson format
     */

    public function getStations()
    {
        $response = $this->fetchData();

// If using JSON...
        $data = json_decode($response, true);
        $data['tot_stations'] = 0;
        $data['tot_slots'] = 0;
        $data['tot_bikes'] = 0;
//  A bit of stats
        foreach ($data['stations'] as $station) {
            $data['tot_stations'] += 1;
            $data['tot_slots'] += $station['slots'];
            $data['tot_bikes'] += $station['bikes'];

        }

        $geoJsonData  = $this->geoJsonify($data);
        //add stats to the data
        $geoJsonData['tot_stations'] = $data['tot_stations'];
        $geoJsonData['tot_slots'] = $data['tot_slots'];
        $geoJsonData['tot_bikes'] = $data['tot_bikes'];
        $geoJsonData['updateTime'] = (new \DateTime())->setTimestamp($data['updateTime'])->format('d-m-Y H:i:s');//format timestamp
        return $geoJsonData;
    }


    /**
     * @param $stationId
     * @return array
     * Returns data for a single station in geojson format
     */
    public function getStation($stationId)
    {
        $api_response = $this->fetchData();
        $data = json_decode($api_response, true);
        $station = ['stations' => [$data['stations'][$stationId - 1]]];
        return $this->geoJsonify($station);
//        return $station;
    }

}