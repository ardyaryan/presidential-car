<?php

class DriverController extends BaseController {

    public function logout()
    {
        Session::flush();
        return Redirect::to('/');
    }

    public function newTrip()
    {
        if(!Session::get('logged')){
            return Redirect::to('/');
        };
        $carId = Session::get('car_id');
        $car = Cars::find($carId);

        return View::make('driver/newTrip')->with('car', array('car_id' => $car->id, 'car_name' => $car->name, 'car_reg' => $car->registration));
    }

    public function saveNewTrip()
    {
        $post = Input::all();

        //\Log::info(__METHOD__.' //========> $newDailyTrip : '.print_r($newDailyTrip, 1));
        if($post != null) {
            try{
                $newDailyTrip = new DailyTrips();
                $newDailyTrip->user_id             = Session::get('user_id');
                $newDailyTrip->car_id              = Session::get('car_id');
                $newDailyTrip->client_id           = $post['client_id'];
                $newDailyTrip->departure_km        = $post['departure_km'];
                $newDailyTrip->departure_date_time = $post['departure_date_time'];
                $newDailyTrip->arrival_km          = $post['arrival_km'];
                $newDailyTrip->arrival_date_time   = $post['arrival_date_time'];;
                $newDailyTrip->departure_address   = $post['departure_address'];
                $newDailyTrip->arrival_address     = $post['arrival_address'];
                $newDailyTrip->trip_cost           = null;
                $newDailyTrip->delete_req         = null;
                $newDailyTrip->edit_req           = null;

                $newDailyTrip->save();
                $result = array('success' => true, 'message' => 'New trip entered successfully');

            }catch(Exception $ex) {
                \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
                $result = array('success' => false, 'message' => 'an error occurred');
            }
            return $result;
        }
    }

    public function getTrips()
    {
        $post = Input::all();
        $startDate =  date('Y-m-d', strtotime(str_replace('-','/',$post['start_date'])));
        $endDate =  date('Y-m-d', strtotime(str_replace('-','/',$post['end_date'])));

        $result = DailyTrips::whereBetween('date', array($startDate, $endDate) )->get();

        return json_encode($result);
    }


    public function getDrivers()
    {
        $result = Drivers::all();
        return json_encode($result);
    }

    public function getAvailableCars()
    {
        $availableCars = DB::select(DB::raw('
        SELECT car_id, name, registration FROM (
        SELECT cars.id AS car_id,cars.name, cars.registration, driver.user_id FROM cars
        LEFT JOIN driver
        ON driver.car_id = cars.id
        ) AS used_cars
        WHERE used_cars.user_id IS NULL
        '));

        return array('success' => true, 'available_cars' => $availableCars);
    }

    public function replaceCar()
    {
        $newCarId = Input::get('new_car_id');

        try{
            $userId = Session::get('user_id');
            $driver = Driver::where('user_id', '=', $userId)->firstOrFail();

            $driver->car_id = $newCarId;
            $driver->save();

            Session::set('car_id', $newCarId);
            $newCar = Cars::find($newCarId);

            $results = array('success' => true, 'message' => 'New Car assigned.', 'new_car' => $newCar);
        }
        catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
            $results = array('success' => false, 'message' => 'an error occurred');
        }

        return $results;

    }

    public static function myTrips()
    {
        if(!Session::get('logged')) {
            return Redirect::to('/');
        };

        return View::make('driver/myTrips');
    }

    public function showMyTrips()
    {

        $userId = Session::get('user_id');

        $to = Input::get('to');
        $from = Input::get('from');

        if($from == null || $to == null) {
            $today = LocationController::getTime();
            $todayFrom = $today['date'].' 00:00:00';
            $todayTo = $today['date'].' 23:59:59';
        }else {
            $todayFrom = $from.' 00:00:00';
            $todayTo = $to.' 23:59:59';
        }

        try{
            $myTrips = DailyTrips::where('user_id', '=', $userId)
                ->where('departure_date_time','>', $todayFrom)
                ->where('departure_date_time','<', $todayTo)
                ->orderBy('departure_date_time', 'desc')->get()->toArray();

            $carId = Session::get('car_id');
            $car = Cars::find($carId);

            if($myTrips == null) {
                $myTrips = array('my_trips' => 'no trips have been recorded for you.');
            };

            $results = array('success' => true, 'my_trips' => $myTrips, 'car' => $car);
        }
        catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
            $results = array('success' => false, 'message' => 'an error occurred');
        }

        return $results;
    }

    public function getTripById()
    {
        $tripId = Input::get('trip_id');

        $myTrip = DailyTrips::find($tripId)->toArray();

        if($myTrip == null) {
            $myTrip = array('my_trips' => 'no trips associated with this id');
        }else {
            $client = Client::find($myTrip['client_id']);
            $myTrip['client_name'] = $client->name;
        }

        return $myTrip;
    }

    public function requestDeletion()
    {
        $tripId = Input::get('trip_id');

        try {
            $myTrip = DailyTrips::find($tripId);
            $myTrip->delete_req = 1;
            $myTrip->save();

            $results = array('success' => true, 'message' => 'deletion requested');

        }catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
            $results = array('success' => false, 'message' => 'an error occurred');
        }
        return $results;
    }

    public function requestRevision()
    {
        $tripId = Input::get('trip_id');
        $carName = Input::get('car');
        $clientName = Input::get('client');
        $departureKm = Input::get('start_km');
        $arrivalKm = Input::get('end_km');
        $departureDateTime = Input::get('start_time');
        $arrivalDateTime = Input::get('end_time');
        $departureAddress = Input::get('departure_address');
        $arrivalAddress = Input::get('destination_address');

        $car = Cars::where('name', '=', substr($carName, 0, 2))->first();
        if($car instanceof Cars) {
            $carId = $car->id;
        }else {
            $carId = '';
        }

        $client = Client::where('name', '=', $clientName)->first();
        if($client instanceof Client) {
            $clientId = $client->id;
        }else {
            $clientId = '';
        }



        try {
            $myTrip = DailyTrips::find($tripId);
            $myTrip->edit_req = 1;
            $myTrip->save();

            $myTripRevison = new DailyTripsRevision();
            $myTripRevison->trip_id             = $tripId;
            $myTripRevison->user_id             = Session::get('user_id');
            $myTripRevison->car_id              = $carId;
            $myTripRevison->client_id           = $clientId;
            $myTripRevison->departure_km        = $departureKm;
            $myTripRevison->departure_date_time = $departureDateTime;
            $myTripRevison->arrival_km          = $arrivalKm;
            $myTripRevison->arrival_date_time   = $arrivalDateTime;
            $myTripRevison->departure_address   = $departureAddress;
            $myTripRevison->arrival_address     = $arrivalAddress;
            $myTripRevison->trip_cost           = null;

            $myTripRevison->save();

            $results = array('success' => true, 'message' => 'revision requested');

        }catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
            $results = array('success' => false, 'message' => 'an error occurred');
        }
        return $results;
    }


}
