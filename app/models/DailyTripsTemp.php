<?php

class DailyTripsTemp extends Eloquent  {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'daily_trips_temp';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

    public $timestamps  = false;

    protected $filables = array('client_id',
                                'user_id',
                                'car_id',
                                'customer_name',
                                'customer_email',
                                'customer_phone',
                                'parking_fee',
                                'toll_fee',
                                'departure_km',
                                'departure_date_time',
                                'departure_address',
                                'extra_charge',
                                'extra_cost',
                                'trip_mode',
                                'flat_rate',
                                'daily_rate',
                                'hourly_rate',
                                'base_rate',
                                'per_km',
                                'per_min'
                            );

}
