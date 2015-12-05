<?php

class DailyTrips extends Eloquent  {


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

    protected $filables = array('client_name', 'date', 'departure_hour', 'departure_minute', 'departure_ampm', 'arrival_hour', 'arrival_minute', 'arrival_ampm', 'departure_address', 'arrival_address', 'water_bottle', 'price_per_trip');

}
