<?php

class AdminController extends BaseController {

	public function index()
	{
       return View::make('admin/login');
	}

    public function login()
    {
        $email    = Input::get('email');
        $password = Input::get('password');

        $user = \Users::where('email', '=', $email)->first();

        if($user != null) {
            \Session::set('logged', true);
            \Session::set('email', $email);
            \Session::set('user_id', $user->id);
            $result = array('success' => true, 'message' => 'logged in successfully');
        }else {
            \Session::flush();
            $result = array('success' => false, 'message' => 'invalid email or password');
        }

        return $result;
    }

    public function tripsEntry()
    {
        return View::make('admin/trips');
    }
}
