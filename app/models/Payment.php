<?php

//use Illuminate\Auth\UserTrait;
//use Illuminate\Auth\UserInterface;
//use Illuminate\Auth\Reminders\RemindableTrait;
//use Illuminate\Auth\Reminders\RemindableInterface;

class Payment extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'payment';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('updated_at', 'deleted_at');

    protected $filables = array('amount', 'other', 'currency', 'user_id');

}
