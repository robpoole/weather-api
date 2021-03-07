<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Cities extends Controller
{
    // Return a list of cities
    public function index()
    {
        $cities = array(
            "Adelaide",
            "Brisbane",
            "Cairns",
            "Darwin",
            "Hobart",
            "Perth",
            "Melbourne",
            "Sydney"
        );
        return $cities;
    }
}
