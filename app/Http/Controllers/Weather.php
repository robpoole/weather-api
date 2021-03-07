<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Weather extends Controller
{
    // Put together our main forecast function
    public function index($location = "Brisbane")
    {
        // Grab our App ID from the .env file
        $appID = env("WEATHER_APP_ID", "");

        // Set up the base URL for the API
        $baseUrl = "api.openweathermap.org/data/2.5/forecast";

        // Set up the required parameters for the API call
        $params = array(
            "appid" => $appID,
            "q" => $location,
            "units" => "metric"
        );

        // Put the URL together
        $url = "${baseUrl}?". http_build_query($params);

        // Call the API!
        $response = Http::get($url);

        // If all is good...
        if ($response->successful()) {

            // Set up our return array
            $return = array();

            // Grab the response in json format
            $j = $response->json();

            // Loop through our results
            foreach ($j['list'] as $key => $val) {

                // Just output the midday reading for simplicity
                if (date("H", $val['dt']) === "12") {

                    // Output the forecast date, temperature and description
                    $return[] = array(
                        'day' => date("D j", $val['dt']),
                        'temp' => round($val['main']['temp']),
                        'desc' => $val['weather'][0]['main']
                    );
                }
            }
            return $return;

        } else {
            // Handle our errors
            if ($response->clientError()) {
                return("Error performing request: ".$response->getStatusCode());
            } elseif ($response->serverError()) {
                return("Error from Server: ".$response->getStatusCode());
            } else {
                return("Error! ".$response->getStatusCode());
            }
        }
    }
}
