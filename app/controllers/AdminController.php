<?php

class AdminController extends BaseController {

	public function index()
	{
       return View::make('admin/login');
	}

    public function login()
    {
        $email    = Input::get('email');
        $password = Input::get('password');

        $user = \Users::where('email', '=', $email)->first();

        if($user != null) {
            \Session::set('logged', true);
            \Session::set('email', $email);
            \Session::set('user_id', $user->id);
            $result = array('success' => true, 'message' => 'logged in successfully');
        }else {
            \Session::flush();
            $result = array('success' => false, 'message' => 'invalid email or password');
        }

        return $result;
    }

    public function tripsEntry()
    {
        return View::make('admin/trips');
    }

    public function newDailyTrip()
    {
        $post = Input::all();
        \Log::info(print_r($post,1));
        if($post != null) {
            try{
                $newDailyTrip = new DailyTrips();
                $newDailyTrip->client_name      = $post['client_name'];
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

            }catch(Exception $ex) {
                \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
            }
        }


    }
}
