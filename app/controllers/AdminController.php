<?php

class AdminController extends BaseController {

	public function index()
	{
        $loggedIn = Session::get('logged');

        if(isset($loggedIn) && $loggedIn == true) {
            if(Session::get('role') == Roles::DRIVER_ROLE) {
                return Redirect::to('driver/newtrip');
            }else {
                return Redirect::to('admin/viewtrips');
            }
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
            Session::set('lid', $user->language_id);
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

                    $newUser->first         = $post['first'];
                    $newUser->last          = $post['last'];
                    $newUser->email         = $post['email'];
                    $newUser->password      = $password;
                    $newUser->role_id       = $post['role_id'];
                    $newUser->language_id   = $post['language_id'];
                    $newUser->time_zone     = $post['time_zone'];

                    $newUser->save();

                    if($post['role_id'] == Roles::DRIVER_ROLE_ID) {

                        $newDriver = new Driver();

                        $newDriver->user_id       = $newUser->id;
                        $newDriver->code          = $post['driver_code'];
                        $newDriver->first         = $post['first'];
                        $newDriver->last          = $post['last'];
                        $newDriver->gsm_number    = $post['gsm'];

                        $newDriver->save();
                    }

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
            $trips = DailyTrips::where('departure_date_time','>', $todayFrom)
                ->where('departure_date_time','<', $todayTo)
                ->orderBy('departure_date_time', 'desc')->get();

            $results = [];

            if(!is_null($trips)) {
                foreach($trips as $trip) {
                    $driverId = $trip->user_id;

                    $carId    = $trip->car_id;
                    $clientId = $trip->client_id;
                    $distance = $trip->arrival_km - $trip->departure_km;

                    $driver = Driver::where('user_id', '=', $driverId)->first();
                    $car    = Cars::find($carId);
                    $client = Client::find($clientId);

                    $finalTrip = [
                        'trip_id'           => $trip->id,
                        'driver'            => $driver->first.' '.$driver->last,
                        'car'               => $car->name,
                        'client'            => $client->name,
                        'customer'          => $trip->customer_name,
                        'departure_time'    => date("H:i:s",strtotime($trip->departure_date_time)),
                        'arrival_time'      => date("H:i:s",strtotime($trip->arrival_date_time)),
                        'departure_address' => $trip->departure_address,
                        'arrival_address'   => $trip->arrival_address,
                        'distance'          => $distance,
                        'cost'              => $trip->trip_cost.' '.$trip->currency,
                        'date'              => date("Y-d-m",strtotime($trip->arrival_date_time)),
                        'delete'            => $trip->delete_req,
                        'edit'              => $trip->edit_req
                    ];
                    array_push($results, $finalTrip);
                }
            }

        } catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
        }

        return json_encode($results);
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
        $results = Driver::all()->toArray();

        foreach ($results as $key => $driver) {
            $driverName = $driver['first'].' '.$driver['last'];
            $email = Users::where('id', '=', $driver['user_id'])->pluck('email');
            $hours = Driver::getHoursByDriverId($driver['user_id']);
            $trips = Driver::getTripsByDriverId($driver['user_id']);
            $earning = Driver::getEarningsByDriverId($driver['user_id']);

            $results[$key]['hours'] =  $hours['hours'];
            $results[$key]['trips'] =  $trips['count'];
            $results[$key]['earning'] =  $earning['earning'];//.' '.$earning['currency'];
            $results[$key]['name'] = $driverName;
            $results[$key]['email'] = $email;
            unset($results[$key]['first']);
            unset($results[$key]['last']);
        }

        return json_encode($results);
    }

    public function viewCars()
    {
        return View::make('admin/viewCars');
    }

    public function getCars()
    {
        $results = Cars::all()->toArray();

        return json_encode($results);
    }

    public function getTripsByDriver() {

        $to = Input::get('to');
        $from = Input::get('from');

        if($from == null || $to == null) {
            $todayFrom = (date('Y-m-d', strtotime('-30 day'))).' 00:00:00';
            $todayTo = date('Y-m-d').' 23:59:59';
        }else {
            $todayFrom = $from.' 00:00:00';
            $todayTo = $to.' 23:59:59';
        }

        $results = [];

        try{

            $trips = DB::table('daily_trips')
                ->select(DB::raw('*, count(id) as count'))
                ->where('departure_date_time','>', $todayFrom)
                ->where('departure_date_time','<', $todayTo)
                ->groupBy(DB::raw('DATE_FORMAT(arrival_date_time, "%Y/%d/%m")'))//)'arrival_date_time')
                ->orderBy('departure_date_time')
                ->get();

            if(!is_null($trips)) {
                foreach ($trips as $trip) {
                    $coordinates = [];
                    $coordinates['x'] = date('Y-m-d', strtotime($trip->arrival_date_time));
                    $coordinates['y'] = $trip->count;
                    //$coordinates['name'] = 'Driver Id: '.$trip->user_id;

                    array_push($results, $coordinates);
                }
            }
            /*
            $queries = DB::getQueryLog();
            $last_query = end($queries);
            */
        } catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
        }
        \Log::info(__METHOD__.' | =====> $results : '.print_r($results,1 ));
        //return json_encode($results);

        $results = [['x'=> '2016-02-01', 'y'=> 1],['x'=> '2016-02-02', 'y'=> 2],['x'=> '2016-02-03', 'y'=> 1]];
        \Log::info(__METHOD__.' | =====> $results : '.print_r($results,1 ));
        return $results;
    }

    public function getDriverById() {

        $driverId = Input::get('driver_id');

        try {
            $driver = Driver::find($driverId);
            $email = Users::where('id', '=', $driver->user_id)->pluck('email');
            $driver->email = $email;
            $result = array('success' => true, 'driver' => $driver);

        }catch(Exception $ex) {
            \Log::error(__METHOD__ . ' | error :' . print_r($ex, 1));
            $result = array('success' => false, 'driver' => null);
        }
        return $result;
    }

    public function saveDriver() {

        $driverId = Input::get('driver_id');
        $code     = Input::get('code');
        $first = Input::get('first');
        $last = Input::get('last');
        $email = Input::get('email');
        $gsmNumber = Input::get('gsm_number');
        $carId = Input::get('car_id');

        try {
            $driver = Driver::find($driverId);

            $driver->code = $code;
            $driver->first = $first;
            $driver->last = $last;
            $driver->gsm_number = $gsmNumber;
            $driver->car_id = $carId;

            $driver->save();

            $user = Users::find($driver->user_id);
            $user->email = $email;
            $user->save();

            $result = array('success' => true);

        }catch(Exception $ex) {
            \Log::error(__METHOD__ . ' | error :' . print_r($ex, 1));
            $result = array('success' => false);
        }
        return $result;
    }

    public function deleteTrip()
    {
        $tripId = Input::get('trip_id');

        try {
            $myTrip = DailyTrips::find($tripId);
            $myTrip->delete();

            $results = array('success' => true, 'message' => 'deletion requested');

        }catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
            $results = array('success' => false, 'message' => 'an error occurred');
        }
        return $results;
    }

    public function saveNewDriver() {

        $code     = Input::get('code');
        $first = Input::get('first');
        $last = Input::get('last');
        $email = Input::get('email');
        $password = Input::get('password');
        $gsmNumber = Input::get('gsm_number');
        $carId = Input::get('car_id');
        $timeZone = Input::get('time_zone');
        $languageId = Input::get('language_id');

        try {
            $user = new Users;

            $user->first = $first;
            $user->last  = $last;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->role_id = Roles::DRIVER_ROLE_ID;
            $user->language_id = $languageId;
            $user->time_zone = $timeZone;
            $user->save();

            $driver = new Driver;

            $driver->user_id = $user->id;
            $driver->code = $code;
            $driver->first = $first;
            $driver->last = $last;
            $driver->gsm_number = $gsmNumber;
            $driver->car_id = $carId;

            $driver->save();

            $result = array('success' => true);

        }catch(Exception $ex) {
            \Log::error(__METHOD__ . ' | error :' . print_r($ex, 1));
            $result = array('success' => false);
        }
        return $result;
    }

    public function deleteDriver()
    {
        $driverId = Input::get('driver_id');

        try {
            $driver = Driver::find($driverId);
            $userId = $driver->user_id;
            $driver->delete();

            $user = Users::find($userId)->delete();

            $results = array('success' => true, 'message' => 'deletion requested');

        }catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
            $results = array('success' => false, 'message' => 'an error occurred');
        }
        return $results;
    }

    public function saveNewCar() {

        $name     = Input::get('name');
        $brand = Input::get('brand');
        $model = Input::get('model');
        $registration = Input::get('registration');
        $policeNumber = Input::get('police_number');
        $uberNumber = Input::get('uber_number');

        try {
            $user = new Cars;

            $user->name = $name;
            $user->brand  = $brand;
            $user->model = $model;
            $user->registration = $registration;
            $user->police_number = $policeNumber;
            $user->uber_number = $uberNumber;
            $user->save();

            $result = array('success' => true);

        }catch(Exception $ex) {
            \Log::error(__METHOD__ . ' | error :' . print_r($ex, 1));
            $result = array('success' => false);
        }
        return $result;
    }

    public function deleteCar()
    {
        $carId = Input::get('car_id');

        try {
            $car = Cars::find($carId);
            $car->delete();

            $results = array('success' => true, 'message' => 'deletion done');

        }catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
            $results = array('success' => false, 'message' => 'an error occurred');
        }
        return $results;
    }

    public function getCarById() {

        $carId = Input::get('car_id');

        try {
            $car = Cars::find($carId);

            $result = array('success' => true, 'car' => $car);

        }catch(Exception $ex) {
            \Log::error(__METHOD__ . ' | error :' . print_r($ex, 1));
            $result = array('success' => false, 'car' => null);
        }
        return $result;
    }

    public function saveCar() {

        $carId = Input::get('car_id');
        $name     = Input::get('name');
        $brand = Input::get('brand');
        $model = Input::get('model');
        $registration = Input::get('registration');
        $policeNumber = Input::get('police_number');
        $uberNumber = Input::get('uber_number');

        try {
            $car = Cars::find($carId);

            $car->name = $name;
            $car->brand = $brand;
            $car->model = $model;
            $car->registration = $registration;
            $car->police_number = $policeNumber;
            $car->uber_number = $uberNumber;

            $car->save();

            $result = array('success' => true);

        }catch(Exception $ex) {
            \Log::error(__METHOD__ . ' | error :' . print_r($ex, 1));
            $result = array('success' => false);
        }
        return $result;
    }

    public function getEditedTripById() {
        $tripId = Input::get('trip_id');

        try {

            $originalTrip = DailyTrips::find($tripId)->toArray();
            $editedTrip   = DailyTripsRevision::where('trip_id', '=', $tripId)->first()->toArray();

            $trip = array ('original_trip' => $originalTrip, 'edited_trip' => $editedTrip);

            $result = array('success' => true, 'trip' => $trip);

        }catch(Exception $ex) {
            \Log::error(__METHOD__ . ' | error :' . print_r($ex, 1));
            $result = array('success' => false);
        }
        return $result;
    }

    public function saveEditedTrip() {
        $tripId = Input::get('trip_id');
        $edited_customer_name = Input::get('edited_customer_name');
        $edited_start_km = Input::get('edited_start_km');
        $edited_end_km = Input::get('edited_end_km');
        $edited_start_time = Input::get('edited_start_time');
        $edited_end_time = Input::get('edited_end_time');
        $edited_departure_address = Input::get('edited_departure_address');
        $edited_destination_address = Input::get('edited_destination_address');


        try {

            $originalTrip = DailyTrips::find($tripId);

            $originalTrip->customer_name = $edited_customer_name;
            $originalTrip->departure_km = $edited_start_km;
            $originalTrip->arrival_km = $edited_end_km;
            $originalTrip->departure_date_time = $edited_start_time;
            $originalTrip->arrival_date_time = $edited_end_time;
            $originalTrip->departure_address = $edited_departure_address;
            $originalTrip->arrival_address = $edited_destination_address;
            $originalTrip->edit_req = null;
            $originalTrip->save();

            DailyTripsRevision::where('trip_id', '=', $tripId)->first()->delete();

            $result = array('success' => true);

        }catch(Exception $ex) {
            \Log::error(__METHOD__ . ' | error :' . print_r($ex, 1));
            $result = array('success' => false);
        }
        return $result;
    }
}
