<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Response;
use Excel;

class Course_Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if($this->user->role !== 1){
                return redirect('/unauthorized');
            }
            return $next($request);
        });
    }

    public function course(Request $request, $option = null){
    	if($option === 'add'){
    		$this->validate($request, [
	            'courseDescription' => 'required|max:255',
	        ]);

	        $data = [
				'name' => $request->courseDescription,
			];	
	        
	        $insert = DB::table('course')
	        ->insertGetId($data);

	        if($insert){
                $data = array(
                    'id' => $insert,
                    'name' => $request->courseDescription,
                );
                echo json_encode($data);
            }
    	}
    }
}
