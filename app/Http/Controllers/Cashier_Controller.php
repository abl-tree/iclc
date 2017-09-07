<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Response;

class Cashier_Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){    	
        return view('pages/cashier');
    }

    public function cashier($option = null){
    	if($option === 'list'){
	        $cashier = DB::select('select * from cashier_profile');

	        foreach ($cashier as $key => $value) {
	            $data[$key][] = $cashier[$key]->first_name.' '.$cashier[$key]->last_name;
	            $data[$key][] = $cashier[$key]->position;
	        }

	        $table_data = array(
	            "draw" => 1,
	            "recordsTotal" => count($data),
	            "recordsFiltered" => count($data),
	            'data' => $data, 
	            );

	        echo json_encode($table_data);
	    }
    }
}
