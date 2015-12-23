<?php

class AdminController extends BaseController {

	public function index()
	{
        $loggedIn = Session::get('logged');

        if(isset($loggedIn) && $loggedIn == true) {
            return Redirect::to('admin/viewtrips');
        }

        return View::make('admin/login');
	}

    public function login()
    {
        $email    = Input::get('email');
        $password = Input::get('password');

        $user = Users::where('email', '=', $email)->first();

        if( $user != null && Hash::check($password, $user->password) ) {
            Session::set('logged', true);
            Session::set('email', $email);
            Session::set('time_zone', $user->time_zone);
            Session::set('user_id', $user->id);
            $userRole = Roles::getUserRole($user->role_id);
            Session::set('role', $userRole);

            // getting car_id if its a driver
            if($user->role_id == Roles::DRIVER_ROLE_ID) {
                $driver = Driver::where('user_id', '=', $user->id)->firstOrFail();
                Session::set('car_id', $driver->car_id);
            }

            $result = array('success' => true, 'message' => 'logged in successfully', 'payload' => array('role' => $userRole));

        }else {
            Session::flush();
            $result = array('success' => false, 'message' => 'invalid email or password');
        }

        return $result;
    }

    public function logout()
    {
        Session::flush();
        return Redirect::to('/');
    }

    public function newTrips()
    {
        return View::make('admin/newTrips');
    }

    public function signUp()
    {
        return View::make('admin/signup');
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

    public function createNewUser()
    {
        $post = Input::all();

        $email = $post['email'];

        $user = Users::where('email', '=', $email)->first();

        if($user != null) {
            return array('success' => false, 'message' => 'Email already exists!');
        }

        if($post != null) {
            $password = $post['password'];
            $confirmedPassword = $post['password_2'];

            if($password != $confirmedPassword) {
                $result = array('success' => false, 'message' => 'passwords do not match');
            }else {

                $password = Hash::make($password);

                try{
                    $newUser = new Users();
                    $newUser->first    = $post['first'];
                    $newUser->last     = $post['last'];
                    $newUser->email    = $post['email'];
                    $newUser->password = $password;
                    $newUser->role_id  = $post['role_id'];

                    $newUser->save();

                    $result = array('success' => true, 'message' => 'New user saved successfully');

                }catch(Exception $ex) {
                    \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
                    $result = array('success' => false, 'message' => 'en error occurred');
                }
            }

            return $result;

        }
    }

    public function viewTrips()
    {
        if(!Session::get('logged')) {
            return Redirect::to('/');
        }
        return View::make('admin/viewTrips');
    }

    public function getTrips()
    {
        $post = Input::all();
        $startDate =  date('Y-m-d', strtotime(str_replace('-','/',$post['start_date'])));
        $endDate =  date('Y-m-d', strtotime(str_replace('-','/',$post['end_date'])));

        $result = DailyTrips::whereBetween('date', array($startDate, $endDate) )->get();

        return json_encode($result);
    }

    public function viewDashboard()
    {
        return View::make('admin/dashboard');
    }

    public function viewDrivers()
    {
        return View::make('admin/viewDrivers');
    }

    public function getDrivers()
    {
        $result = Drivers::all();
        \Log::info(print_r($result, 1));
        return json_encode($result);
    }
}
