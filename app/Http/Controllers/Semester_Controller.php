<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Response;

class Semester_Controller extends Controller
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

    public function semester(Request $request, $option = null){
    	if($option === 'add'){
    		$this->validate($request, [
	            'semesterDescription' => 'required|max:255',
	        ]);

	        $data = [
				'description' => $request->semesterDescription,
			];	
	        
	        $insert = DB::table('semester')
	        ->insertGetId($data);

	        if($insert){
                $data = array(
                    'id' => $insert,
                    'name' => $request->semesterDescription,
                );
                echo json_encode($data);
            }
    	}else if($option === 'acadyear'){
    		$this->validate($request, [
	            'acadyearDescription' => 'required|max:255',
	        ]);

	        $data = [
				'description' => $request->acadyearDescription,
			];	
	        
	        $insert = DB::table('school_year')
	        ->insertGetId($data);

	        if($insert){
                $data = array(
                    'id' => $insert,
                    'name' => $request->acadyearDescription,
                );
                echo json_encode($data);
            }
    	}
    }
}
