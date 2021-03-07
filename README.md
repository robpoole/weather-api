# Getting Started

Once you have cloned the repo navigate to the project folder and run `php artisan serve`.

# Walkthrough of Project

The project consists of two API endpoints, and two console commands.

## APIs

The cities API is very straight forward and simply returns a hardcoded list of cities, via an index route and a plain array response.

The weather API uses an App ID which is stored in `.env` to query our API. This API returns weather readings for every three hours over the next five days, so I loop through the json results and only include the midday readings in our results for simplicity. I format the date to a nice short format and round the temperature

At the bottom I handle client errors, server errors and then any other errors that the API might throw at us.

These can be tested by firing a `get` API request at the following URLS once your local setup is up and running

`http://127.0.0.1:8000/api/cities`

`http://127.0.0.1:8000/api/weather/brisbane`

## Console Commands

These should hopefully perform the equivalent of the API endpoints, and can be tested with the following commands:

`php artisan city:list`

`php artisan weather:forecast "Brisbane"`