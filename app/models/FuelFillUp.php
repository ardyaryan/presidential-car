<?php

class FuelFillUp extends Eloquent  {


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fuel_fill_up';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

    public $timestamps  = false;

    protected $filables = array('user_id', 'car_id', 'date_and_time', 'cost', 'amount', 'price_per_liter');

}
