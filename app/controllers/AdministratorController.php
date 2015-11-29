<?php
/**
 * Created by PhpStorm.
 * User: Adboom-Developer
 * Date: 12/29/2014
 * Time: 3:53 PM
 */
 class AdministratorController extends BaseController {

     public function index()
     {
         return View::make('wrapper')
             ->with('This is inside Administrator Controller, <br/> No data is passed');
     }
     public function getVars($data)
     {

         return View::make('wrapper')
             ->with('data',$data);
     }
     public function CreateTable()
     {
         Schema::create('users',function($newTable){
             $newTable->increments('id');
             $newTable->string('name',20);
             $newTable->string('email',20);
             $newTable->text('description');
             $newTable->date('created');
             $newTable->timestamps();
         });
     }
     public function UpdateTable()
     {
         Schema::table('users',function($newColumn){
             $newColumn->boolean('enabled');
             //$newColumn->dropColumn('description');
         });
     }
     public function CreateUser($user)
     {
        $newUser = new Users();
        $newUser->name = $user['name'];
        $newUser->email = $user['email'];
        $newUser->description = $user['description'];
        $newUser->created = date('m-d-y');
        $newUser->save();
     }
     public function SignUp()
     {
         $user = Input::get();
         $this->CreateUser($user);
         return View::make('thankyou');
     }
     public function BrowseAll()
     {
         $allUsers = Users::all();
         return View::make('browse')
             ->with('users',$allUsers);

     }
     public function DeleteUser($id)
     {
         $user = Users::find($id);
         $user->delete();
         return Redirect::to('browse');
     }
 }