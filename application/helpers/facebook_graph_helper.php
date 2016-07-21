<?php namespace helpers;


require 'application\helpers\curl_helper.php';
use helpers\CurlHelper;
//require('app\config.php');

class FacebookGraphHelper
{

    public static function getAccessToken()
    {

        $configs = include('application\config\facebook_api.php');
        $app_id = $configs['app_id'];// "159228921157128";
        $app_secret =  $configs['app_secret']; //"ccbb21ca556d2fe2595614746357d27c";
        $access_token = null;
        $APPLICATION_API_URL_ENV_KEY= $configs['facebook_graph_url']; //"https://graph.facebook.com/v2.6";

        try 
        {
            $request = $APPLICATION_API_URL_ENV_KEY .
                    "oauth/access_token?client_id=" .
                    $app_id .

                    "&client_secret=" . $app_secret.
                    "&grant_type=client_credentials";
                $response = CurlHelper::execute($request);
                $access_token = json_decode($response)->access_token;
        }

        catch(Exception $e) {
        }
        return $access_token;
    }
    public static function getResponse($url, $filter, $isPaging = true, &$nextPage)
    {

        try {
            $queryString = $filter;
            foreach($queryString as $key => $value) {
                //echo $key;
            }
            $access_token = FacebookGraphHelper::getAccessToken();
            $queryString += array('access_token' => $access_token);
            $queryString += array('limit' => 50);
            $url = $url. "?" .  http_build_query($queryString);
            $curlHelper = new CurlHelper;
            $jsonResponse = $curlHelper->execute($url);
           
            $facebookData = json_decode($jsonResponse,true);
            if(json_last_error() >0 )
            {
                echo json_last_error_msg();

            }
            if($facebookData != null && array_key_exists("error", $facebookData) )
            {

                echo $facebookData["error"]["message"];

            }
            else
            {
                if ($isPaging == true) {
                    if (FacebookGraphHelper::nextPageExists($facebookData) == true)
                        $nextPage = $facebookData["paging"]["next"];
                }
            }
        }
        catch(exception $ex)
        {
            echo $ex;
        }

        return $facebookData;
    }

    public static function getNextPageResponse($url, &$nextPage)
    {

        try {
            $curlHelper = new CurlHelper;
            $jsonResponse  = $curlHelper->execute($url);
            $facebookData = json_decode($jsonResponse,true);
            // echo json_last_error();
            if($facebookData != null &&  array_key_exists("error", $facebookData) )
            {
                echo $facebookData["error"]["message"];
            }
            else
            {
                if (FacebookGraphHelper::nextPageExists($facebookData) == true)
                    $nextPage = $facebookData["paging"]["next"];
            }

            return $facebookData;
        }
        catch(exception $ex)
        {
            echo $ex;
        }
    }

    private static function nextPageExists($data)
    {
        $value = false;
        if ($data != null && array_key_exists("paging", $data)) {
            if (array_key_exists("next", $data["paging"])) {
                $value = true;
            }
        }

        return $value;
    }

    public static function getPages()
    {
        $configs = include('application\config\facebook_api.php');
        $categories = $configs['categories'];
        $locations = $configs['locations'];
        $url = $configs['facebook_graph_url'] . 'search';
        $pages = [];

        foreach ($locations as $location){

            foreach ($categories as $category) {
                //foreach($)
                $q = $category . ' in ' . $location;
                //$q = str_replace(' ', '%', $q);
                $request = ['q' => $q, 'type' => 'page'];
                $nextPage = "";
                $facebookResponse = FacebookGraphHelper::getResponse($url, $request, true, $nextPage);
                //$page[] = $facebookResponse;

                if(array_key_exists("data", $facebookResponse) && count($facebookResponse["data"]) >0) {
                    $pages[] = $facebookResponse;
                    unset($facebookResponse);

                    while ($nextPage != "") {
                        $url = $nextPage;
                        $nextPage = "";
                        $facebookResponse = FacebookGraphHelper::getNextPageResponse($url, $nextPage);
                        if (count($facebookResponse["data"]) > 0) {
                            $pages[] = $facebookResponse;
                        }
                        unset($facebookResponse);
                    }
                }


            }

        }
        return $pages;

    }






}
