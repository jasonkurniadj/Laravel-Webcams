<?php

namespace App\Classes;

use Illuminate\Support\Facades\Http;

class Webcam
{
    public function __construct()
    {
        $this->endpoint = 'https://api.windy.com/api/webcams/v2/list/limit=%d,%d';
        $this->apiKey = config('app.x_windy_key');
        $this->maxLimit = 50;
    }

    public function getCountries()
    {
        $endpoint = sprintf($this->endpoint, 50, 0);
        $queryParams = [
            'show' => 'countries'
        ];

        return $this->hit($endpoint, $queryParams);
    }

    public function getCategories()
    {
        $endpoint = sprintf($this->endpoint, 50, 0);
        $queryParams = [
            'show' => 'categories'
        ];

        return $this->hit($endpoint, $queryParams);
    }

    public function getOrderBy()
    {
        $orderBy = [
            "popularity",
            "hotness",
            "new",
            "recent"
        ];

        return $orderBy;
    }
    
    public function getWebcamsByCountry($countryCode='all', $limit=20, $offset=0, $categories=[], $orderBy='none')
    {
        $endpoint = sprintf($this->endpoint, $limit, $offset);
        $countryCode = strtoupper($countryCode);
        $orderBy = strtolower($orderBy);

        if($countryCode !== 'ALL') {
            $endpoint .= '/country='.$countryCode;
        }
        if(count($categories) > 0) {
            $endpoint .= '/category=';

            foreach($categories as $idx=>$category) {
                if($idx === 0) $endpoint .= $category;
                else $endpoint .= ','.$category;
            }
        }
        if($orderBy !== 'none') {
            $endpoint .= '/orderby='.$orderBy;
        }

        $queryParams = [
            'show' => 'webcams:image,location'
        ];

        return $this->hit($endpoint, $queryParams);
    }

    public function getWebcamsByCoordinate($lat, $long, $rad=250, $limit=20, $offset=0)
    {
        $endpoint = $this->endpoint.'/nearby=%d,%d,%d/orderby=distance';
        $endpoint = sprintf($endpoint, $limit, $offset, $lat, $long, $rad);

        $queryParams = [
            'show' => 'webcams:image,location'
        ];

        return $this->hit($endpoint, $queryParams);
    }

    public function getWebcam($webcamID)
    {
        $endpoint = $this->endpoint.'/webcam=%d';
        $endpoint = sprintf($endpoint, $this->maxLimit, 0, $webcamID);

        $queryParams = [
            'show' => 'webcams:category,image,location,player'
        ];

        return $this->hit($endpoint, $queryParams);
    }

    private function hit($endpoint, $queryParams)
    {
        try {
            $response = Http::withHeaders([
                'x-windy-key' => $this->apiKey
            ])->get($endpoint, $queryParams);

            $jsonResp = json_decode($response->body());
        }
        catch(Exception $ex) {
            $jsonResp = json_encode( json_decode("{}") );
        }

        return $jsonResp;
    }
}
