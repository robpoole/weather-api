<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class WeatherForecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:forecast {location=Brisbane}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'weather:forecast {location : the name of the location}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Grab our location (city) parameter
        $location = $this->argument('location');

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

            // Grab the response in json format
            $j = $response->json();

            // Loop through our results
            foreach ($j['list'] as $key => $val) {

                // Just output the midday reading for simplicity
                if (date("H", $val['dt']) === "12") {

                    // Output the forecast date, temperature and description
                    $this->info(date("D j", $val['dt']) . " | " . 
                        round($val['main']['temp']) . " | " . 
                        $val['weather'][0]['main']);
                }
            }
        } else {
            // Handle our errors
            if ($response->clientError()) {
                $this->error("Error performing request: ".$response->getStatusCode());
            } elseif ($response->serverError()) {
                $this->error("Error from Server: ".$response->getStatusCode());
            } else {
                $this->error("Error! ".$response->getStatusCode());
            }
        }
    }
}
