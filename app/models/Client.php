<?php

//use Illuminate\Auth\UserTrait;
//use Illuminate\Auth\UserInterface;
//use Illuminate\Auth\Reminders\RemindableTrait;
//use Illuminate\Auth\Reminders\RemindableInterface;

class Client extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'client';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

    public $timestamps  = false;

    protected $filables = array('name', 'base', 'price_per_km', 'price_per_min', 'currency', 'us_dollar_exchange_rate');

}
