<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function build_response(
        $status          = 'SUCCESS',
        $message         = "",
        $arr_data        = [],
        $response_format = 'json'
    )
    {
    	if($response_format == 'json')
    	{
    		$arr_response = [
                'status'  => $status,
                'message' => $message
    		];

    		if(sizeof($arr_data)>0)
    		{
    			$arr_response['response_data'] = $arr_data;
    		}
    		return response()->json($arr_response,200,[],JSON_UNESCAPED_UNICODE)->header('Access-Control-Allow-Origin','*');
    	}
    	
    }
}
