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
        $clients = Client::all();

        if(! $car instanceof Cars ) {
            $carId = 0;
            $carName = 'N/A';
            $carRegistration = 'N/A';
        }else {
            $carId = $car->id;
            $carName = $car->name;
            $carRegistration = $car->registration;
        }

        return View::make('driver/newTrip')->with('car', array('car_id' => $carId, 'car_name' => $carName, 'car_reg' => $carRegistration))
            ->with('clients' , $clients);
    }

    public function myFuelTank()
    {
        $carId = Session::get('car_id');
        $car = Cars::find($carId);
        if(! $car instanceof Cars ) {
            $carId = 0;
            $carName = 'N/A';
            $carRegistration = 'N/A';
            return View::make('driver/newTrip')->with('car', array('car_id' => $carId, 'car_name' => $carName, 'car_reg' => $carRegistration));
        }else {
            return View::make('driver/myFuelTank')->with('car', array('car_id' => $car->id, 'car_name' => $car->name, 'car_reg' => $car->registration));
        }

    }

    public function saveNewTrip()
    {
        $post = Input::all();
        /**
         * b : base fare
         * ct : cost per time
         * cd : cost per distance
         * If your ride lasted for time T and you rode a distance of D, the total cost is simply b + ct∗T + cd∗D.
         */

        $startKm    = $post['departure_km'];
        $endKm      = $post['arrival_km'];
        $tripKm     = $endKm - $startKm;

        $startTime  = strtotime($post['departure_date_time']);
        $endTime    = strtotime($post['arrival_date_time']);
        $tripTime   = ($endTime - $startTime) / 60;

        $clientId   = $post['client_id'];
        try{
            $client     = Client::find($clientId);
            $baseFare   = $client->base;
            $costPerKm  = $client->price_per_km;
            $costPerMin = $client->price_per_min;
            $currency   = $client->currency;

        }catch (Exception $ex){
            \Log::error(__METHOD__.' | error : '.print_r($ex, 1));
        }

        $tripCost = $baseFare + ($costPerKm * $tripKm) + ($costPerMin * $tripTime);

        if($post != null) {
            try{
                $newDailyTrip = new DailyTrips();
                $newDailyTrip->user_id             = Session::get('user_id');
                $newDailyTrip->car_id              = Session::get('car_id');
                $newDailyTrip->client_id           = $clientId;
                $newDailyTrip->customer_name       = $post['customer_name'];
                $newDailyTrip->departure_km        = $startKm;
                $newDailyTrip->departure_date_time = $post['departure_date_time'];
                $newDailyTrip->arrival_km          = $endKm;
                $newDailyTrip->arrival_date_time   = $post['arrival_date_time'];
                $newDailyTrip->departure_address   = $post['departure_address'];
                $newDailyTrip->arrival_address     = $post['arrival_address'];
                $newDailyTrip->trip_cost           = $tripCost;
                $newDailyTrip->currency            = $currency;
                $newDailyTrip->delete_req          = null;
                $newDailyTrip->edit_req            = null;

                $newDailyTrip->save();
                $result = array('success' => true, 'message' => 'New trip entered successfully');

            }catch(Exception $ex) {
                \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
                $result = array('success' => false, 'message' => 'an error occurred');
            }
            return $result;
        }
    }

    public function saveFuelFillUp()
    {
        $post = Input::all();

        $dateAndTime  = $post['date_and_time'];
        $cost   = $post['cost'];
        $amount = $post['amount'];
        $pricePerLiter = $cost / $amount;

        try{
            $FuelFillUp = new FuelFillUp();

            $FuelFillUp->user_id = Session::get('user_id');
            $FuelFillUp->car_id = Session::get('car_id');
            $FuelFillUp->date_and_time = $dateAndTime;
            $FuelFillUp->cost = $cost;
            $FuelFillUp->amount = $amount;
            $FuelFillUp->price_per_liter = $pricePerLiter;
            $FuelFillUp->save();

            $result = array('success' => true, 'message' => 'Fuel Fill-up saved');

        }catch (Exception $ex){
            \Log::error(__METHOD__.' | error : '.print_r($ex, 1));
            $result = array('success' => false, 'message' => 'an error occurred');
        }

        return $result;
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
        $customerName = Input::get('customer_name');
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
            $myTripRevison->customer_name       = $customerName;
            $myTripRevison->departure_km        = $departureKm;
            $myTripRevison->departure_date_time = $departureDateTime;
            $myTripRevison->arrival_km          = $arrivalKm;
            $myTripRevison->arrival_date_time   = $arrivalDateTime;
            $myTripRevison->departure_address   = $departureAddress;
            $myTripRevison->arrival_address     = $arrivalAddress;
            $myTripRevison->trip_cost           = null;

            $myTripRevison->save();

            $results = array('success' => true, 'message' => 'revision requested');

        } catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
            $results = array('success' => false, 'message' => 'an error occurred');
        }
        return $results;
    }

}
