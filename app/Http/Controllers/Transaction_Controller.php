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
        $result = array();
        $balance = array();
        $percentage = 0;

        $this->validate($request, [
            'academicYear' => 'required|max:255',
            'semester' => 'required|max:255',
            'student-id' => 'required|max:255',
            'studentID' => 'required|max:255',
            ]);

    	if($option === 'payment'){
            $data = [
                'sy_id' => $request->academicYear,
                'semester_id' => $request->semester,
                'student_id' => $request['student-id'],
                'student_number' => $request->studentID
                ];

            $payment = array(
                'item' => DB::table('item')
                ->select('id', 'amount as item_amount', DB::raw('0 as amount'))
                ->where(['sy_id'=>$data['sy_id'], 'semester_id'=>$data['semester_id'], 'option'=>1]),
                'balance' => DB::table('payment as a')
                ->select('c.id', DB::raw('sum(b.amount) as amount'), DB::raw('c.amount as item_amount'))
                ->join('payment_item as b','a.id','b.payment_id')
                ->rightJoin('item as c', 'c.id', 'b.item_id')
                ->where(['c.option'=> 1, 'c.sy_id'=>$data['sy_id'], 'c.semester_id'=>$data['semester_id']])
                ->where(function($q) use ($data) {
                      $q->where('a.student_id', $data['student_id'])
                        ->orWhereNull('a.student_id');
                  })
                ->groupBy(DB::raw('c.id, c.amount'))
                );

            if($payment['balance']->get()->isEmpty()){
                $payment['balance'] = $payment['item'];
            }
            
            foreach ($payment['balance']->get() as $key => $value) {
                $balance[$key]['item_id'] = $value->id;
                $balance[$key]['balance'] = $value->item_amount - $value->amount;
                $percentage += $balance[$key]['balance'];
            }

            echo json_encode($percentage);
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
                'total_amount' => $request['cash-amount']
                ];

            $payment = array(
                'item' => DB::table('item')
                ->select('id', 'amount as item_amount', DB::raw('0 as amount'))
                ->where(['sy_id'=>$data['sy_id'], 'semester_id'=>$data['semester_id'], 'option'=>1]),
                'balance' => DB::table('payment as a')
                ->select('c.id', DB::raw('sum(b.amount) as amount'), DB::raw('c.amount as item_amount'))
                ->join('payment_item as b','a.id','b.payment_id')
                ->rightJoin('item as c', 'c.id', 'b.item_id')
                ->where(['c.option'=> 1, 'c.sy_id'=>$data['sy_id'], 'c.semester_id'=>$data['semester_id']])
                ->where(function($q) use ($data) {
                      $q->where('a.student_id', $data['student_id'])
                        ->orWhereNull('a.student_id');
                  })
                ->groupBy(DB::raw('c.id, c.amount'))
                );

            if($payment['balance']->get()->isEmpty()){
                $payment['balance'] = $payment['item'];
            }
            
            foreach ($payment['balance']->get() as $key => $value) {
                $balance[$key]['item_id'] = $value->id;
                $balance[$key]['balance'] = $value->item_amount - $value->amount;
                $percentage += $balance[$key]['balance'];
            }

            if(round(floatval($data['total_amount']), 15) == 0 || round(floatval($percentage), 15) == 0){
                return 'true';
            }

            if(round(floatval($data['total_amount']), 15) >= round(floatval($percentage), 15)){
                $percentage = 1;
            }else{
                $percentage = round(floatval($data['total_amount']), 15)/round(floatval($percentage), 15);
            }
            $total = 0;

            // foreach ($balance as $key => $value) {
            //     $result[$key]['item_id'] = $value['item_id'];
            //     $result[$key]['payment_id'] = 0;
            //     $result[$key]['quantity'] = 1;
            //     $result[$key]['size'] = 'S';
            //     $result[$key]['amount'] = intval($value['balance'] * $percentage);
            //     $total += $result[$key]['amount'];
            // }

            // dd($result, $total);
    
            $insert = DB::table('payment')
            ->insertGetId($data);

            foreach ($balance as $key => $value) {
                $result[$key]['item_id'] = $value['item_id'];
                $result[$key]['payment_id'] = $insert;
                $result[$key]['quantity'] = 1;
                $result[$key]['size'] = 'S';
                $result[$key]['amount'] = $value['balance'] * $percentage;
            }

            $insertItem = DB::table('payment_item')
            ->insert($result);

            echo json_encode($insert);
        }
    }
}
