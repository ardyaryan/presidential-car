<?php

class DailyTrips extends Eloquent  {

    const TRIP_MODE = 1;
    const FREE_MODE = 2;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'daily_trips';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

    public $timestamps  = false;

    protected $filables = array('client_id', 'user_id', 'car_id', 'customer_name', 'customer_email', 'customer_phone', 'parking_fee', 'toll_fee', 'departure_km', 'departure_date_time', 'arrival_km', 'arrival_date_time', 'departure_address', 'arrival_address', 'trip_cost', 'extra_charge', 'extra_cost', 'trip_time', 'trip_distance', 'currency', 'delete_req', 'edit_req');

}
