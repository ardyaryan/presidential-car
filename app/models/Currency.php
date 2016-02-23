<?php

class Currency extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'currency';

    public $timestamps  = false;

    protected $filables = array('currency');

}
