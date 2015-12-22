<?php

class DriverController extends BaseController {

    public function logout()
    {
        Session::flush();
        return Redirect::to('/');
    }

    public function newTrip()
    {
        return View::make('driver/newTrip');
    }

    public function newDailyTrip()
    {
        $post = Input::all();
        if($post != null) {
            try{
                $newDailyTrip = new DailyTrips();
                $newDailyTrip->client_name      = $post['client_name'];
                $newDailyTrip->date             = date('Y-m-d', strtotime(str_replace('-', '/', $post['date'])));
                $newDailyTrip->departure_hour   = $post['departure_hour'];
                $newDailyTrip->departure_minute = $post['departure_minute'];
                $newDailyTrip->departure_ampm   = $post['departure_ampm'];
                $newDailyTrip->arrival_hour     = $post['arrival_hour'];
                $newDailyTrip->arrival_minute   = $post['arrival_minute'];
                $newDailyTrip->arrival_ampm     = $post['arrival_ampm'];
                $newDailyTrip->departure_address = $post['departure_address'];
                $newDailyTrip->arrival_address  = $post['arrival_address'];
                $newDailyTrip->water_bottle     = $post['water_bottle'];
                $newDailyTrip->price_per_trip   = $post['price_per_trip'];
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
