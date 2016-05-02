<?php

use Illuminate\Support\Facades\Mail;
use Symfony\Component\Security\Core\User\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Tests\Controller;

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

    public function showEmailForm()
    {
        if(!Session::get('logged')){
            return Redirect::to('/');
        }

        return View::make('driver/emailForm');
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
        if(!Session::get('logged')){
            return Redirect::to('/');
        };
        $tripCost = 0;
        $post = Input::all();
        /**
         * b : base fare
         * ct : cost per time
         * cd : cost per distance
         * If your ride lasted for time T and you rode a distance of D, the total cost is simply b + ct∗T + cd∗D.
         */
        if($post != null) {
            try{
                $startKm    = $post['departure_km'];
                $endKm      = $post['arrival_km'];

                $phone = (int) $post['phone'];
                $emailAddress = $post['email'];

                $flatPrice = $post['flat_price'];
                $dailyPrice = $post['daily_price'];
                $hourlyPrice = $post['hourly_price'];

                $base = $post['base'];
                $perKm = $post['per_km'];
                $perMin = $post['per_min'];

                $tripMode = $post['trip_mode'];
                $tollFee = $post['toll_fee'];
                $parkingFee = $post['parking_fee'];
                $tempTripId = $post['temp_trip_id'];

                if (!empty($tollFee) || !empty($parkingFee)) {
                    if ($tripMode == DailyTrips::FREE_MODE) {
                        $extraCharge = 0;
                        $extraCost = $tollFee + $parkingFee;
                    } else {
                        $extraCharge = $tollFee + $parkingFee;
                        $extraCost = 0;
                    }
                } else {
                    $extraCost = $extraCharge = 0;
                }

                $tripKm     = $endKm - $startKm;

                $startTime  = strtotime($post['departure_date_time']);
                $endTime    = strtotime($post['arrival_date_time']);
                $tripTime   = ($endTime - $startTime) / 60;

                $clientId   = $post['client_id'];

                if (!empty($clientId)) {
                    try{
                        $client     = Client::find($clientId);
                        $baseFare   = $client->base;
                        $costPerKm  = $client->price_per_km;
                        $costPerMin = $client->price_per_min;
                        $currency   = $client->currency;

                        $tripCost = $baseFare + ($costPerKm * $tripKm) + ($costPerMin * $tripTime);

                    }catch (Exception $ex){
                        \Log::error(__METHOD__.' | error : '.print_r($ex, 1));
                    }
                } else {
                    if (!empty($base) && !empty($perKm) && !empty($perMin)) {
                        $baseFare = $base;
                        $costPerKm = $perKm;
                        $costPerMin = $perMin;

                        $tripCost = $baseFare + ($costPerKm * $tripKm) + ($costPerMin * $tripTime);
                    }
                }

                if (!empty($flatPrice)) {
                    $tripCost = $flatPrice;
                }

                if (!empty($hourlyPrice)) {
                    $tripCost = $tripTime * ( $hourlyPrice / 60 );
                }

                if (!empty($daily1Price)) {
                    $tripCost = $tripTime * ( $dailyPrice / (24 * 60) );
                }

                $tripCost += $extraCharge;

                $newDailyTrip = new DailyTrips();
                $newDailyTrip->user_id             = Session::get('user_id');
                $newDailyTrip->car_id              = Session::get('car_id');
                $newDailyTrip->client_id           = $clientId;
                $newDailyTrip->customer_name       = $post['customer_name'];
                $newDailyTrip->toll_fee            = $tollFee;
                $newDailyTrip->parking_fee         = $parkingFee;
                $newDailyTrip->customer_email      = $post['email'];
                $newDailyTrip->customer_phone      = $phone;
                $newDailyTrip->departure_km        = $startKm;
                $newDailyTrip->departure_date_time = $post['departure_date_time'];
                $newDailyTrip->arrival_km          = $endKm;
                $newDailyTrip->arrival_date_time   = $post['arrival_date_time'];
                $newDailyTrip->departure_address   = $post['departure_address'];
                $newDailyTrip->arrival_address     = $post['arrival_address'];
                $newDailyTrip->trip_cost           = $tripCost;
                $newDailyTrip->extra_cost          = $extraCost;
                $newDailyTrip->extra_charge        = $extraCharge;
                $newDailyTrip->currency            = $currency;
                $newDailyTrip->trip_time           = $tripTime;
                $newDailyTrip->trip_distance       = $tripKm;
                $newDailyTrip->delete_req          = null;
                $newDailyTrip->edit_req            = null;

                $newDailyTrip->save();

                if(!empty($email) && strpos($email, '@') ) {
                    $messageBody = 'Your trip with Presidential Car cost: ' . $currency . ' ' . round($tripCost, 2);
                    CommunicationController::sendEmail($emailAddress, $messageBody, 'emails/cost', 'Your Trip Receipt');

                    $email = new Email();
                    $email->email_address = $emailAddress;
                    $email->message       = $messageBody;
                    $email->date_sent     = $post['arrival_date_time'];
                    $email->save();
                }


                /*
                CommunicationController::sendSmsToNumber($phone, $messageBody);

                $message = new Message();
                $message->phone     = $phone;
                $message->cost      = $tripCost;
                $message->message   = $messageBody;
                $message->currency  = $currency;
                $message->date_sent = $post['arrival_date_time'];
                $message->save();
                */
                $tempTrip = DailyTripsTemp::find($tempTripId);//->delete();
                \Log::info(__METHOD__.' | ============= Temp Trip: '.  print_r($tempTrip,1));
                if ($tempTrip instanceof DailyTripsTemp) {
                    $tempTrip->delete();
                }
                \Session::set('temp_trip', '');
                $result = array('success' => true, 'message' => 'New trip entered successfully');

            }catch(Exception $ex) {
                \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
                $result = array('success' => false, 'message' => 'an error occurred');
            }

            return $result;
        }
    }

    public function saveNewTempTrip()
    {
        $post = Input::all();
        /**
         * b : base fare
         * ct : cost per time
         * cd : cost per distance
         * If your ride lasted for time T and you rode a distance of D, the total cost is simply b + ct∗T + cd∗D.
         */
        if($post != null) {
            try{
                $startKm    = $post['departure_km'];

                $phone = $post['phone'];
                $emailAddress = $post['email'];

                $flatPrice = $post['flat_price'];
                $dailyPrice = $post['daily_price'];
                $hourlyPrice = $post['hourly_price'];

                $base = $post['base'];
                $perKm = $post['per_km'];
                $perMin = $post['per_min'];

                $tripMode = $post['trip_mode'];
                $tollFee = $post['toll_fee'];
                $parkingFee = $post['parking_fee'];

                if (!empty($tollFee) || !empty($parkingFee)) {
                    if ($tripMode == DailyTrips::FREE_MODE) {
                        $extraCharge = 0;
                        $extraCost = $tollFee + $parkingFee;
                    } else {
                        $extraCharge = $tollFee + $parkingFee;
                        $extraCost = 0;
                    }
                } else {
                    $extraCost = $extraCharge = 0;
                }

                $clientId   = $post['client_id'];

                $newDailyTripTemp = new DailyTripsTemp();
                $newDailyTripTemp->user_id             = Session::get('user_id');
                $newDailyTripTemp->car_id              = Session::get('car_id');
                $newDailyTripTemp->client_id           = $clientId;
                $newDailyTripTemp->customer_name       = $post['customer_name'];
                $newDailyTripTemp->toll_fee            = $tollFee;
                $newDailyTripTemp->parking_fee         = $parkingFee;
                $newDailyTripTemp->customer_email      = $emailAddress;
                $newDailyTripTemp->customer_phone      = $phone;
                $newDailyTripTemp->departure_km        = $startKm;
                $newDailyTripTemp->departure_date_time = $post['departure_date_time'];
                $newDailyTripTemp->departure_address   = $post['departure_address'];
                $newDailyTripTemp->extra_charge        = $extraCharge;
                $newDailyTripTemp->extra_cost          = $extraCost;
                $newDailyTripTemp->trip_mode           = $tripMode;
                $newDailyTripTemp->flat_rate           = $flatPrice;
                $newDailyTripTemp->daily_rate          = $dailyPrice;
                $newDailyTripTemp->hourly_rate         = $hourlyPrice;
                $newDailyTripTemp->base_rate           = $base;
                $newDailyTripTemp->per_km              = $perKm;
                $newDailyTripTemp->per_min             = $perMin;

                $newDailyTripTemp->save();

                \Session::set('temp_trip', $newDailyTripTemp);

                $result = array('success' => true, 'message' => 'temp trip entered successfully', 'temp_trip_id' => $newDailyTripTemp->id);

            }catch(Exception $ex) {
                \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
                $result = array('success' => false, 'message' => 'an error occurred');
            }

            return $result;
        }
    }

    /**
     * this function is only created to test Mailgun ,the route is : {domain}/driver/showemailform
     * @return array
     */
    public function sendEmail()
    {
        try {

            $post = Input::all();
            $phone = $post['phone'];
            $email = $post['email'];
            $messageBody = $post['message'];

            CommunicationController::sendEmail($email,$messageBody,'emails/test', 'Test Email');
            CommunicationController::sendSmsToNumber($phone, $messageBody);

            $result = array('success' => true, 'message' => 'Email Send successfully');

        } catch(Exception $ex) {
            \Log::error(__METHOD__.' | error :' . $ex);
            $result = array('success' => false, 'message' => 'an error occurred');
        }
        return $result;
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
        $customerEmail = Input::get('customer_email');
        $customerPhone = Input::get('customer_phone');
        $departureKm = Input::get('start_km');
        $arrivalKm = Input::get('end_km');
        $departureDateTime = Input::get('start_time');
        $arrivalDateTime = Input::get('end_time');
        $departureAddress = Input::get('departure_address');
        $arrivalAddress = Input::get('destination_address');

        $car = Cars::where('name', '=', substr($carName, 0, 3))->first();
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
            $myTripRevison->customer_email      = $customerEmail;
            $myTripRevison->customer_phone      = $customerPhone;
            $myTripRevison->departure_km        = $departureKm;
            $myTripRevison->departure_date_time = $departureDateTime;
            $myTripRevison->arrival_km          = $arrivalKm;
            $myTripRevison->arrival_date_time   = $arrivalDateTime;
            $myTripRevison->departure_address   = $departureAddress;
            $myTripRevison->arrival_address     = $arrivalAddress;

            $myTripRevison->save();

            $results = array('success' => true, 'message' => 'revision requested');

        } catch(Exception $ex){
            \Log::error(__METHOD__.' | error :'.print_r($ex, 1));
            $results = array('success' => false, 'message' => 'an error occurred');
        }
        return $results;
    }

}
