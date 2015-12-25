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
                $newDailyTrip->water_bottle        = $post['water_bottle'];
                $newDailyTrip->price_per_trip      = null;
                $newDailyTrip->save();
                $result = array('success' => true, 'message' => 'New trip entered successfully');

            }catch(Exception $ex) {
                \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
                $result = array('success' => false, 'message' => 'en error occurred');
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
            $results = array('success' => false, 'message' => 'en error occurred');
        }

        return $results;

    }
}
