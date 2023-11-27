<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Session;
use Cookie;
use Hash;
class ApiController extends Controller
{
    public function __construct()
    {
    	$this->arr_view_data  = [];
        $this->auth = auth()->guard('users');
        $this->User = new User();
    }
    public function process_login(Request $request)
    {
		$arr_response = [];
		$arr_rules                   = array();  	 
		$arr_rules['email']          = "required|email";
		$arr_rules['password']       = "required";

		$validator  = Validator::make($request->all(),$arr_rules);
	    if($validator->fails())
		{
			$msg    = "Validation Error, Please fill up the all mandatory fields";
    		if($validator->errors())
    		{
    			$arr_response['error'] = $validator->errors()->first();
    		}
    		return $this->build_response('ERROR',$msg,$arr_response);
		}
        $obj_user = $this->User->where('email',$request->only('email'))->first();
        if($obj_user) 
        {
            if($this->auth->attempt($request->only('email', 'password')))
            {
                $arr_response['user_id'] = $obj_user->id ?? "";
                $arr_response['name'] = $obj_user->name ?? "";
                $arr_response['email'] = $obj_user->email ?? "";
                return $this->build_response('SUCCESS','You are successfully login to your account',$arr_response);
            }
            else
            {
                return $this->build_response('ERROR','Invalid Login Credential');
            }
        }
        else
        {
            return $this->build_response('ERROR','Invalid Login Credential');
        }
    }
    public function users_list()
    {
        $arr_users = $arr_response = [];
        $obj_user = $this->User->orderBy('id', 'DESC')->get();
        if($obj_user)
        {
            $arr_users = $obj_user->toArray();
        }
        if(count($arr_users) > 0 )
        {
            $arr_response['users'] = $arr_users;
            return $this->build_response('SUCCESS','Users List', $arr_response);
        }
        return $this->build_response('ERROR','Data not found');
    }
}
