<?php

//use Illuminate\Auth\UserTrait;
//use Illuminate\Auth\UserInterface;
//use Illuminate\Auth\Reminders\RemindableTrait;
//use Illuminate\Auth\Reminders\RemindableInterface;

class Cars extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cars';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

    public $timestamps  = false;

    protected $filables = array('name', 'brand', 'model', 'registration', 'police_number', 'uber_number');

}
