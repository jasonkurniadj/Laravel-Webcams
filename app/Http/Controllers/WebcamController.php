<?php

namespace App\Http\Controllers;

use App\Classes\Webcam;
use Illuminate\Http\Request;
use Exception;
use Cache;

class WebcamController extends Controller
{
    public function __construct()
    {
        $this->cdCountries = config('app.cache_duration_countries');
        $this->cdCategories = config('app.cache_duration_categories');
        $this->cdOrderBy = config('app.cache_duration_orderby');
        $this->cdIndex = config('app.cache_duration_index');
        $this->cdSearch = config('app.cache_duration_categories');
        $this->cdWebcam = config('app.cache_duration_webcam');
    }

    public function index()
    {
        $countryCode = 'ID';
        $limit = 15;
        $offset = 0;
        $oWebcam = new Webcam;

        // *** Get Countries ***
        try {
            $countries = Cache::remember('countries', $this->cdCountries, function() use($oWebcam) {
                $jsonCountries = $oWebcam->getCountries();
                $countries = $jsonCountries->result->countries;
                usort($countries, function($a, $b) {
                    return $a->name > $b->name ? 1 : -1;
                });
                return $countries;
            });
        }
        catch(Exception $ex) {
            $countries = [];
            if( config('app.debug') ) print('Ex: '.$ex->getMessage()).'<br>';
        }

        // *** Get Webcam List for Landing Page ***
        try {
            $webcams = Cache::remember('index-'.$countryCode, $this->cdIndex, function()
                use($oWebcam, $countryCode, $limit, $offset) {
                $jsonWebcams = $oWebcam->getWebcamsByCountry($countryCode, $limit, $offset);
                return $jsonWebcams->result->webcams;
            });
        }
        catch(Exception $ex) {
            $webcams = [];
            if( config('app.debug') ) print('Ex: '.$ex->getMessage()).'<br>';
        }

        return view('index', [
            'pageName' => 'Home',
            'countries' => $countries,
            'webcams' => $webcams
            ]
        );
    }

    public function search(Request $request)
    {
        $oWebcam = new Webcam;
        $searchType = $request->type;

        // *** Get Countries ***
        try {
            $countries = Cache::remember('countries', $this->cdCountries, function() use($oWebcam) {
                $jsonCountries = $oWebcam->getCountries();
                $countries = $jsonCountries->result->countries;
                usort($countries, function($a, $b) {
                    return $a->name > $b->name ? 1 : -1;
                });
                return $countries;
            });
        }
        catch(Exception $ex) {
            $countries = [];
            if( config('app.debug') ) print('Ex: '.$ex->getMessage()).'<br>';
        }

        // *** Get Categories ***
        try {
            $categories = Cache::remember('categories', $this->cdCategories, function() use($oWebcam) {
                $jsonCountries = $oWebcam->getCategories();
                $categories = $jsonCountries->result->categories;
                usort($categories, function($a, $b) {
                    return $a->name > $b->name ? 1 : -1;
                });
                return $categories;
            });
        }
        catch(Exception $ex) {
            $categories = [];
            if( config('app.debug') ) print('Ex: '.$ex->getMessage()).'<br>';
        }

        // *** Get Order By ***
        try {
            $orderBy = $oWebcam->getOrderBy();
        }
        catch(Exception $ex) {
            $orderBy = [];
            if( config('app.debug') ) print('Ex: '.$ex->getMessage()).'<br>';
        }

        // *** Get Search Result ***
        try {
            $limit = 15;
            $offset = 0;

            $webcams = Cache::remember($request->getRequestUri(), $this->cdSearch, function() use($oWebcam, $searchType, $request, $limit, $offset) {
                if($searchType === 'coordinate') {
                    $lat = $request->lat;
                    $long = $request->long;
                    $rad = $request->rad;

                    $jsonWebcams = $oWebcam->getWebcamsByCoordinate($lat, $long, $rad, $limit, $offset);
                    $webcams = $jsonWebcams->result->webcams;
                }
                else {
                    $countryCode = $request->countryCode;
                    $searchCategories = $request->categories;
                    $sort = $request->sort;

                    if(empty($countryCode)) $countryCode = 'ALL';
                    if(empty($searchCategories)) $searchCategories = [];
                    if(empty($sort)) $sort = 'none';

                    $jsonWebcams = $oWebcam->getWebcamsByCountry($countryCode, $limit, $offset, $searchCategories, $sort);
                    $webcams = $jsonWebcams->result->webcams;
                }

                return $webcams;
            });
        }
        catch(Exception $ex) {
            $webcams = [];
            if( config('app.debug') ) print('Ex: '.$ex->getMessage()).'<br>';
        }
        
        return view('search', [
            'pageName' => 'Search',
            'countries' => $countries,
            'categories' => $categories,
            'orderBy' => $orderBy,
            'webcams' => $webcams
            ]
        );
    }

    public function webcam($paramID)
    {
        try {
            $webcam = Cache::remember('webcam-'.$paramID, $this->cdWebcam, function() use($paramID) {
                $oWebcam = new Webcam;
                $jsonWebcam = $oWebcam->getWebcam($paramID);
                return $jsonWebcam->result->webcams[0];
            });
            $title = $webcam->title;
            $isOK = true;
        }
        catch(Exception $ex) {
            $isOK = false;
            $title = 'Not Available';
            $webcam = $ex->getMessage();
            if( config('app.debug') ) print('Ex: '.$ex->getMessage()).'<br>';
        }

        return view('webcam', [
            'pageName' => $title,
            'isOK' => $isOK,
            'webcam' => $webcam
            ]
        );
    }
}
