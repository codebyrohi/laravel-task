<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Session;
use Cookie;
use Hash;
use DataTables;
class UserController extends Controller
{
    public function __construct(User $User)
    {
        $this->arr_view_data      = [];
        $this->auth               = auth()->guard('users');
	    $this->module_title       = "User";
	    $this->module_view_folder = "user";
	    $this->module_url_path    = url('/').'/user';
        $this->User               = $User;
        $this->user_image_public_path  = url('/').config('app.img_path.user_image');
        $this->user_image_base_path    = base_path('/').config('app.img_path.user_image');
     
    }
     public function index()
     {
         $this->arr_view_data['module_title'] = $this->module_title." Registration";
         $this->arr_view_data['module_url_path'] = $this->module_url_path;
         return view($this->module_view_folder.'.index',$this->arr_view_data);
     }
     /*store user details*/
     public function store(Request $request)
     {
        $arr_rules = $form_data = $arr_data = array();
        $status = false;
        $arr_rules['name'] = "required|max:255";
        $arr_rules['email'] = "required|email|unique:users,email";
        $arr_rules['password'] = "required|min:6";
        $arr_rules['mobile_no'] = "required|min:10";

        $validator = validator::make($request->all(),$arr_rules);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $form_data = $request->all();
         //validate image & store that image
         if(isset($form_data['image']) )
         {
             $file_name = $form_data['image'];
             $file_extension = strtolower($form_data['image']->getClientOriginalExtension());
             if(in_array($file_extension,['png','jpg','jpeg','gif']))
             {
                 $file_name = time().uniqid().'.'.$file_extension;
                 $isUpload  = $form_data['image']->move($this->user_image_base_path,$file_name);
                 $arr_data['image'] = $file_name;
             }
             else
             {
                 Session::flash('error','Invalid File type');
                 return redirect()->back();
             }
         }
        $arr_data['name'] = $form_data['name']??'';
        $arr_data['email'] = $form_data['email']??'';
        $arr_data['mobile_no'] = $form_data['mobile_no']??'';
        if(isset($form_data['password']) && $form_data['password']!="")
        {
            $arr_data['password'] = Hash::make($form_data['password']);
        }
        $obj_user = $this->User->create($arr_data);   
        if($obj_user){
            $this->auth->login($obj_user);
            Session::flash('success',$this->module_title.' '.'registered successfully');
            return redirect($this->module_url_path);
        }
        else{
           Session::flash('error','Problem occure while creating'.' '.str::singular($this->module_title));
           return redirect()->back();
        }
        
    }
     //load users data using datatable
    public function load_data()
    {
         $obj_user     = $this->User->orderBy('id', 'DESC')->get();
         $json_result     = DataTables::of($obj_user)->make(true);
         $obj_json_result = $json_result->getData();
         if(isset($obj_json_result->data) && sizeof($obj_json_result->data)>0)
         {
             foreach ($obj_json_result->data as $key => $data) 
             {
                $user_image_url = "";
                 if(isset($data->image) && file_exists($this->user_image_base_path.$data->image))
                 {
                     $user_image_url = $this->user_image_public_path.$data->image;
                 }
               
                 $user_image = '<img height="150px" width="200px" src="'.$user_image_url.'">';
                 $obj_json_result->data[$key]->id     = $key+1 ?? '';
                 $obj_json_result->data[$key]->name   = $data->name??'';
                 $obj_json_result->data[$key]->email  = $data->email ??'';
                 $obj_json_result->data[$key]->image  = $user_image ??'';

             }
         }
         return response()->json($obj_json_result);
     }
     /*store user details with ajax*/
     public function ajaxStore(Request $request)
     {
        $arr_rules = $form_data = $arr_data = $arr_response = array();
        $status = false;
        $arr_rules['name'] = "required|max:255";
        $arr_rules['email'] = "required|email|unique:users,email";
        $arr_rules['password'] = "required|min:6";
        $arr_rules['mobile_no'] = "required|min:10";

        $validator = validator::make($request->all(),$arr_rules);
        if($validator->fails()){
            $arr_response['status'] = "error";
            $arr_response['msg'] = "Validation failed !!";
            return response()->json($arr_response);
        }
        $form_data = $request->all();
         //validate image & store that image
        if(isset($form_data['image']) )
        {
             $file_name = $form_data['image'];
             $file_extension = strtolower($form_data['image']->getClientOriginalExtension());
             if(in_array($file_extension,['png','jpg','jpeg','gif']))
             {
                 $file_name = time().uniqid().'.'.$file_extension;
                 $isUpload  = $form_data['image']->move($this->user_image_base_path,$file_name);
                 $arr_data['image'] = $file_name;
             }
             else
             {
                $arr_response['status'] = "error";
                $arr_response['msg'] = "Invalid File type";
                return response()->json($arr_response);
             }
        }
        $arr_data['name'] = $form_data['name']??'';
        $arr_data['email'] = $form_data['email']??'';
        $arr_data['mobile_no'] = $form_data['mobile_no']??'';
        if(isset($form_data['password']) && $form_data['password']!="")
        {
            $arr_data['password'] = Hash::make($form_data['password']);
        }
        $obj_user = $this->User->create($arr_data);   
        if($obj_user){
            $this->auth->login($obj_user);
            $arr_response['status'] = "success";
            $arr_response['msg'] = $this->module_title.' '.'registered successfully';
            return response()->json($arr_response);
        }
        else{
            $arr_response['status'] = "error";
            $arr_response['msg'] = 'Problem occure while creating'.' '.str::singular($this->module_title);
            return response()->json($arr_response);
        }
        
    }
}
