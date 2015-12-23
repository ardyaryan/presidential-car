<?php

class DriverController extends BaseController {

    public function logout()
    {
        Session::flush();
        return Redirect::to('/');
    }

    public function newTrip()
    {
        $carId = Session::get('car_id');
        $car = Cars::find($carId);

        return View::make('driver/newTrip')->with('car', array('car_name' => $car->name, 'car_reg' => $car->registration));
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
}
