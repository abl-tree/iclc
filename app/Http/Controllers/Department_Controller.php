<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Response;

class Department_Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if($this->user->role !== 'client'){
                return redirect('/unauthorized');
            }
            return $next($request);
        });
    }

    public function department(Request $request, $option = null){
    	if($option === 'add'){
    		$this->validate($request, [
	            'departmentDescription' => 'required|max:255',
	        ]);

	        $data = [
				'description' => $request->departmentDescription,
			];	
	        
	        $insert = DB::table('department')
	        ->insertGetId($data);

	        if($insert){
                $data = array(
                    'id' => $insert,
                    'name' => $request->departmentDescription,
                );
                echo json_encode($data);
            }
    	}
    }
}
