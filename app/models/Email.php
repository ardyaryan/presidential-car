<?php


class Email extends Eloquent {



    public $timestamps  = false;
    
    protected $table = 'email';

    protected $filables = array('email_address', 'message', 'date_sent');


}
