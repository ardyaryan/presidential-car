<?php

class Roles extends Eloquent {

	const ADMIN_ROLE_ID = 1;
    const DRIVER_ROLE_ID =2;

    const ADMIN_ROLE = 'admin';
    const DRIVER_ROLE ='driver';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'roles';

    public $timestamps  = false;

    protected $filables = array('role');

    public static function getUserRole($roleId)
    {
        switch($roleId) {
            case self::ADMIN_ROLE_ID :
                return self::ADMIN_ROLE;
                break;
            case self::DRIVER_ROLE_ID :
                return self::DRIVER_ROLE;
                break;
            default:
                return null;
        }
    }
}
