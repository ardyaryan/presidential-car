<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Driver extends Eloquent {

    use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'driver';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    protected $hidden = array('created_at', 'updated_at', 'deleted_at');

    protected $filables = array('user_id', 'code', 'first', 'last', 'car_id', 'gsm_number');

    public static function getHoursByDriverId($driverId) {
        $hoursArray = DB::table('daily_trips')
            ->select(DB::raw('SUM(TIMESTAMPDIFF(SECOND ,departure_date_time, arrival_date_time )) AS hours'))
            ->where('user_id', '=', $driverId)
            ->groupBy('user_id')
            ->get();

        if(!empty($hoursArray)) {
            foreach ($hoursArray as $value) {
                $hours = (array) $value;
            }
        }else {
            $hours = array('hours' => 0);
        }

        return $hours;
    }

    public static function getTripsByDriverId($driverId) {
        $tripsCount = DB::table('daily_trips')
            ->select(DB::raw('COUNT(id) as count'))
            ->where('user_id', '=', $driverId)
            ->groupBy('user_id')
            ->get();

        if(!empty($tripsCount)) {
            foreach ($tripsCount as $value) {
                $count = (array) $value;
            }
        }else {
            $count = array('count' => 0);
        }
        return $count;
    }

    public static function getEarningsByDriverId($driverId) {
        $earningsArray = DB::table('daily_trips')
            ->select(DB::raw('SUM(trip_cost) as earning, currency'))
            ->where('user_id', '=', $driverId)
            ->groupBy('user_id')
            ->get();

        if(!empty($earningsArray)) {
            foreach ($earningsArray as $value) {
                $earning = (array) $value;
            }
        }else {
            $earning = array('earning' => 0, 'currency' => '');
        }

        return $earning;
    }

}
