<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Drivers extends Eloquent {

    use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'drivers';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    protected $hidden = array('updated_at', 'deleted_at');

    protected $filables = array('code', 'first', 'last', 'gsm_number', 'created_at');

}
