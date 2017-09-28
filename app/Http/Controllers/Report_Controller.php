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
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if($this->user->role !== 1){
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

    public function byitem()
    {
        $data = array(
            'semester' => DB::table('semester')->get(), 
            'department' => DB::table('department')->get(), 
            'acadyear' => DB::table('school_year')->get(), 
            'course' => DB::table('course')->get(), 
            );

        return view('pages/itemReport', $data);
    }

    public function report($option = null){
    	if($option === 'receipt'){
            $data = array();
    		$list = array(
    			'payment' => DB::table('payment as a')
    			->select('a.id', 'a.invoice_number', 'b.name', 'a.created_date', 'd.description as sy_desc', 'e.description as sem_desc', 'a.total_amount', 'c.name as course')
                ->join('student as b', 'a.student_id', 'b.id')
                ->join('course as c', 'b.course_id', 'c.id')
                ->join('school_year as d', 'd.id', 'a.sy_id')
    			->join('semester as e', 'e.id', 'a.semester_id')
    			->get(), 
    			);

    		if($list['payment']){
	        	foreach ($list['payment'] as $key => $value) {
	                $data[$key][] = $value->id;
	                $data[$key][] = sprintf("%08d", $value->id);
	                $data[$key][] = $value->name;
                    $data[$key][] = $value->sem_desc;
                    $data[$key][] = $value->sy_desc;
                    $data[$key][] = $value->course;
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
    	}else if($option === 'item'){            
            $data = array();
            $list = array(
                'payment' => DB::table('payment_item as a')
                ->select('a.id', 'b.id as receipt', 'd.name as student_name', 'c.description as item','c.description as item', 'g.description as department', 'e.description as semester', 'f.description as school_year', 'h.name as course', 'c.amount', 'b.created_date')
                ->join('payment as b', 'a.payment_id', 'b.id')
                ->join('item as c', 'a.item_id', 'c.id')
                ->join('student as d', 'b.student_id', 'd.id')
                ->join('semester as e', 'b.semester_id', 'e.id')
                ->join('school_year as f', 'b.sy_id', 'f.id')
                ->join('department as g', 'c.department_id', 'g.id')
                ->join('course as h', 'd.course_id', 'h.id')
                ->get(), 
                );

            if($list['payment']){
                foreach ($list['payment'] as $key => $value) {
                    $data[$key][] = $value->id;
                    $data[$key][] = sprintf("%08d", $value->receipt);
                    $data[$key][] = $value->student_name;
                    $data[$key][] = $value->item;
                    $data[$key][] = $value->semester;
                    $data[$key][] = $value->school_year;
                    $data[$key][] = $value->course;
                    $data[$key][] = $value->department;
                    $data[$key][] = $value->amount;
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
