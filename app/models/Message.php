<?php


class Message extends Eloquent {



    public $timestamps  = false;
    
    protected $table = 'message';

    protected $filables = array('phone', 'message', 'cost', 'currency', 'date_sent');


}
