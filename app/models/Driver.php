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

}
