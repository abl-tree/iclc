<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Response;

class Report_Controller extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Responseg
     */
    public function index()
    {
        $data = array(
            'semester' => DB::table('semester')->get(), 
            'department' => DB::table('department')->get(), 
            'acadyear' => DB::table('school_year')->get(), 
            'course' => DB::table('course')->get(), 
            );

    	return view('pages/report', $data);
    }

    public function report($option = null){
    	if($option === 'receipt'){
    		$list = array(
    			'payment' => DB::table('payment as a')
    			->select('a.id', 'a.invoice_number', 'b.first_name', 'b.last_name', 'a.created_date', 'a.sy_id', 'a.semester_id', 'a.total_amount', 'c.id as course_id')
                ->join('student as b', 'a.student_id', 'b.id')
    			->join('course as c', 'b.course_id', 'c.id')
    			->get(), 
    			);

    		if($list['payment']){
	        	foreach ($list['payment'] as $key => $value) {
	                $data[$key][] = $value->id;
	                $data[$key][] = $value->semester_id;
                    $data[$key][] = $value->sy_id;
	                $data[$key][] = $value->course_id;
	                $data[$key][] = $value->invoice_number;
	                $data[$key][] = $value->first_name.' '.$value->last_name;
	                $data[$key][] = $value->total_amount;
	                $data[$key][] = $value->created_date;
		        }
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
