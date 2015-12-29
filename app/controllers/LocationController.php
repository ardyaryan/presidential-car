<?php

class LocationController extends BaseController  {


	public static function getLocation() {

        $latitude = Input::get('lat');
        $longitude = Input::get('lng');

        if(isset($latitude, $longitude)) {

            $url = sprintf("https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s", $latitude, $longitude);

            $content = file_get_contents($url); // get json content

            $metadata = json_decode($content, true); //json decoder

            if(count($metadata['results']) > 0) {
                // for format example look at url
                // https://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452
                $address = $metadata['results'][0];

                // save it in db for further use
                $results =  $address['formatted_address'];

            }
            else {
                $results =  'address not found';
            }
        }

        return $results;

    }

    public static function getTime() {

        $timeZone = (!is_null(Session::get('time_zone')) ? Session::get('time_zone') : 0);

        $userTime = gmdate('H:i:s', time() + 3600*($timeZone));
        $userDate = gmdate('Y-m-d', time() + 3600*($timeZone));

        return $result = array('date' => $userDate, 'time' => $userTime );

    }
}
