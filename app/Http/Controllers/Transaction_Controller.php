<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Response;

class Transaction_Controller extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Responseg
     */
    public function index()
    {    
        $data = array(
        	'acadyear' => DB::table('school_year')->get(),
        	'semester' => DB::table('semester')->get()
        );

        return view('pages/transaction', $data);
    }

    public function transaction(Request $request, $option = null){        
        $this->validate($request, [
            'academicYear' => 'required|max:255',
            'semester' => 'required|max:255',
            'student-id' => 'required|max:255',
            'studentID' => 'required|max:255',
            ]);

    	if($option === 'payment'){
            $data = [
                'acadyear' => $request->academicYear,
                'semester_id' => $request->semester,
                'student_id' => $request['student-id'],
                'student_number' => $request->studentID
                ];



            $payment = array(
                'item' => DB::table('item')->where(['sy_id'=>$data['acadyear'], 'semester_id'=>$data['semester_id']])->sum('amount'),
                'payment' => DB::table('payment')->where(['sy_id'=>$data['acadyear'], 'semester_id'=>$data['semester_id'], 'student_id'=>$data['student_id']])->sum('total_amount')
                );  

            echo json_encode($payment);
        }else if($option === 'confirm'){                    
            $this->validate($request, [
                'cash-amount' => 'required|max:255',
                'total-amount' => 'required|max:255',
                'cash-change' => 'required|max:255',
                ]);

            $data = [
                'invoice_number' => '00001',
                'sy_id' => $request->academicYear,
                'semester_id' => $request->semester,
                'student_id' => $request['student-id'],
                'cashier_id' => Auth::user()->id,
                'total_amount' => $request['total-amount']
                ];

            $insert = DB::table('payment')
            ->insertGetId($data);

            echo json_encode($insert);
        }
    }
}
