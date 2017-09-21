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

            $data = array(
                'link' => '/transaction/history?student-id='.$data['student_id'].'&semester='.$data['semester_id'].'&academicYear='.$data['sy_id'].'&studentID='.$data['student_number']
                );

            echo json_encode($data);
        }else if($option === 'add_item'){
            $data = [
                'sy_id' => $request->academicYear,
                'semester_id' => $request->semester,
                'student_id' => $request['student-id'],
                'student_number' => $request->studentID
                ];

            $item_id = array_map('intval', explode(',', $request->item_id));

            $payment = array(
                'balance' => DB::table('item')
                ->select(DB::raw('sum(amount) as bal'))
                ->whereIn('id', $item_id)
                ->get()
                );

            echo json_encode($payment['balance']);

        }else if($option === 'confirm'){ 
            $this->validate($request, [
                'cash-amount' => 'required|max:255',
                'total-amount' => 'required|max:255',
                'cash-change' => 'required|max:255',
                'item_id' => 'required|max:255',
                ], [
                'item_id.required' => 'No item selected.'
                ]);

            $data = [
                'invoice_number' => '00001',
                'sy_id' => $request->academicYear,
                'semester_id' => $request->semester,
                'student_id' => $request['student-id'],
                'cashier_id' => Auth::user()->id,
                'total_amount' => $request['cash-amount']
                ];

            $item_id = array_map('intval', explode(',', $request->item_id));

            $payment = array(
                'item' => DB::table('item')
                ->whereIn('id', $item_id)
                ->get()
                );
    
            $insert = DB::table('payment')
            ->insertGetId($data);            

            foreach ($payment['item'] as $key => $value) {
                $result[$key]['item_id'] = $value->id;
                $result[$key]['payment_id'] = $insert;
                $result[$key]['quantity'] = 1;
                $result[$key]['size'] = 'S';
                $result[$key]['amount'] = $value->amount;
            }

            $insertItem = DB::table('payment_item')
            ->insert($result);            

            $data = array(
                'link' => '/transaction/history?student-id='.$data['student_id'].'&semester='.$data['semester_id'].'&academicYear='.$data['sy_id'].'&studentID='.$data['student_id']
                );

            echo json_encode($data);
        }else if($option === "history"){
            $data = [
                'sy_id' => $request->academicYear,
                'semester_id' => $request->semester,
                'student_id' => $request['student-id'],
                'student_number' => $request->studentID
                ];
            $list = array(
                'receipt' => DB::table('payment as a')
                ->where(['sy_id'=>$data['sy_id'], 'semester_id'=>$data['semester_id'], 'student_id'=>$data['student_id']])
                ->join('cashier_profile as b', 'a.cashier_id', 'b.user_id')
                ->get(), 
                );

            foreach ($list['receipt'] as $key => $value) {
                $result[$key][] = $value->invoice_number;
                $result[$key][] = $value->created_date;
                $result[$key][] = $value->total_amount;
                $full_name = $value->first_name.' '.$value->last_name;
                $position = '('.$value->position.')';
                $result[$key][] = $full_name.' '.$position;
            }

            $table_data = array(
                "draw" => 1,
                "recordsTotal" => count($result),
                "recordsFiltered" => count($result),
                'data' => $result, 
                );

            echo json_encode($table_data);
        }else if($option === 'unpaid'){            
            $data = [
                'sy_id' => $request->academicYear,
                'semester_id' => $request->semester,
                'student_id' => $request['student-id']
                ];

            $previousPayment = DB::table('payment as a')
            ->select('b.item_id')
            ->join('payment_item as b', 'a.id', '=', 'b.payment_id')
            ->where(['sy_id'=>$data['sy_id'], 'semester_id'=>$data['semester_id'], 'student_id'=>$data['student_id']])
            ->get();

            foreach ($previousPayment as $key => $value) {
                $result[] = $value->item_id;
            }

            $unpaid = DB::table('item')
            ->where(['sy_id'=>$data['sy_id'], 'semester_id'=>$data['semester_id']])
            ->whereNotIn('id', $result)
            ->get();

            $result = array();
            
            if($unpaid){
                foreach ($unpaid as $key => $value) {
                    $result[$key][] = $value->id;
                    $result[$key][] = $value->description;
                    $result[$key][] = $value->amount;
                    if($value->option === 1){
                        $result[$key][] = "Mandatory";
                    }else if($value->option === 0){
                        $result[$key][] = "Optional";
                    }
                }
            }

            $table_data = array(
                "draw" => 1,
                "recordsTotal" => count($result),
                "recordsFiltered" => count($result),
                'data' => $result, 
                );

            echo json_encode($table_data);
        }
    }
}
