<?php

class DailyTripsRevision extends Eloquent  {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'daily_trips_revision';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

    public $timestamps  = false;

    protected $filables = array('trip_id', 'client_id', 'user_id', 'departure_km', 'departure_date_time', 'arrival_km', 'arrival_date_time', 'departure_address', 'arrival_address', 'water_bottle', 'trip_cost');

}
