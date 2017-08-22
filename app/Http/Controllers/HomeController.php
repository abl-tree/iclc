<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Mail;
use Session;
use Illuminate\Support\Facades\Response;
use Excel;
use PDF;

class HomeController extends Controller
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
        $stats = $this->pie_graph();
        return view('dashboard', $stats);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('edit');
    }

    public function student()
    {
        $payment = 0;
        //join balance and student information table;
        $payments = DB::table('item_lists')
            ->where('Status', '=', 'mandatory')->get();

        $ay = DB::table('academic_year')->get();

        for($x=0; $x<sizeof($payments); $x++){
            $payment = $payment + (float)$payments[$x]->price;
        }

        $overallamount = $payment*2*sizeof($ay);

        echo json_encode($overallamount);

        $users = DB::select("select b.*, coalesce($overallamount - sum(total), $overallamount) as 'status' from payments_table a right join
                (select * from students) b on a.stud_id = b.Student_no group by student_no;");

        return view('data-table', ['students' => $users]);
    }

    public function cashier()
    {
        $users = DB::select('select * from users');

        return view('cashier-data', ['cashiers' => $users]);
    }

    public function item()
    {
        $items = DB::select('select * from item_lists');

        return view('items', ['items' => $items]);
    }

    public function accountUpdate(Request $request)
    {
        $data = ['update' => true];
        $this->validate($request, [
            'fName' => 'required|max:255',
            'lName' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $full_name = $request['fName']." ".$request['lName'];

        $update = [
                    'name' => $full_name,
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                  ];

        DB::table('users')
        ->where('id', Auth::user()->id)
        ->update($update);
        
        return redirect('/edit', compact('data'));
    }

    //Items functions
    //addItem()
    //updateItem()
    //deleteItem()

    public function addItem(Request $request)
    {
        $this->validate($request, [
            'itemName' => 'required|max:255',
            'itemPrice' => 'required|max:255',
            'itemStatus' => 'required|max:255',
            
        ]);

        $item = [
                    'name' => $request->itemName,
                    'price' => $request->itemPrice,
                    'status' => $request->itemStatus,
                    'created_at'=>date('Y-m-d H:i:s'),
                  ];

        DB::table('item_lists')
        ->insert($item);

        $items = DB::select('select * from item_lists');

        return view('items', ['items' => $items]);
    }

    public function updateItem(Request $request)
    {
        $this->validate($request, [
            'itemName' => 'required|max:255',
            'itemPrice' => 'required|max:255',
            'itemStatus' => 'required|max:255',
        ]);

        $item = [
                    'name' => $request->itemName,
                    'price' => $request->itemPrice,
                    'status' => $request->itemStatus,
                    'updated_at'=>date('Y-m-d H:i:s'),
                  ];

        DB::table('item_lists')
        ->where('name', $request->itemName)
        ->update($item);

        $items = DB::select('select * from item_lists');
        echo json_encode($items);
    }
    
    public function deleteItem(Request $request)
    {
        $this->validate($request, [
            'itemName' => 'required|max:255',
        ]);

        $item = [
                    'name' => $request->itemName,
                  ];
        DB::delete('delete from item_lists where name = ?',[$request->itemName]);

        $items = DB::select('select * from item_lists');
        echo json_encode($items);

    }

    //Student functions
    //addStudent
    //updateStudent
    //deleteStudent

    public function addStudent(Request $request){
         $this->validate($request, [
            'studNum' => 'required|max:255',
            'studName' => 'required|max:255',
            'studYear' => 'required|max:255',
            'studCourse' => 'required|max:255',
            'studGender' => 'required|max:255',
        ]);

        $student = [
                    'Student_No' => $request->studNum,
                    'Student_Name' => $request->studName,
                    'Gender' => $request->studGender,
                    'Year'=>$request->studYear,
                    'Course'=>$request->studCourse,
                  ];

        DB::table('students')
        ->insert($student);

        $students = DB::select('select * from students');
        echo json_encode($students);


        
    }

    public function updateStudent(Request $request){
        $this->validate($request, [
            'studNum' => 'required|max:255',
            'studName' => 'required|max:255',
            'studYear' => 'required|max:255',
            'studCourse' => 'required|max:255',
            'studGender' => 'required|max:255',
        ]);

        $student = [
                    'Student_No' => $request->studNum,
                    'Student_Name' => $request->studName,
                    'Gender' => $request->studGender,
                    'Year'=>$request->studYear,
                    'Course'=>$request->studCourse,
                  ];

        DB::table('students')
        ->where('Student_Name', $request->studName)
        ->update($student);

        $students = DB::select('select * from students');
        echo json_encode($students);
    }   

    public function deleteStudent(Request $request)
    {
        $this->validate($request, [
            'studNum' => 'required|max:255',
        ]);

        $student = [
                    'Student_No' => $request->studNum,
                  ];
        DB::delete('delete from students where Student_No = ?',[$request->studNum]);

        $students = DB::select('select * from students');
        echo json_encode($students);

    }

    //Transactions Functions
    //Calculations of payables, accountabilities
    //Calculates total amount paid

    public function transaction($id = null, $acad_year = null, $semester = null)    {
        $sum = 0;
        $previous_payment = 0;
        $new_payment = 0;

        $student = DB::table('students')->where('Student_No', '=', $id)->limit(1)->get();

        $ay = DB::table('academic_year')->orderBy('id', 'desc')->get();

        $opt_payments = DB::table('item_lists')
        ->where('Status', '=', 'optional')->get();

        if(sizeof($student) > 0 && $acad_year == null && $semester == null){   
            $payments = DB::table('item_lists')
            ->where('Status', '=', 'mandatory')->get();

            $balance = DB::table('payments_table')
            ->where([['stud_id', '=', $id], ['academic_year', '=', $ay[0]->academic_year], ['semester', '=', 1]])->get();

            for($x=0; $x<sizeof($payments); $x++){
                $new_payment = $new_payment + (float)$payments[$x]->price;
            }
            for($x=0; $x<sizeof($balance); $x++){
                $previous_payment = $previous_payment + (float)$balance[$x]->total;
            }

            if(sizeof($balance) == 0){
                for($x=0; $x<sizeof($payments); $x++){
                    $sum = $sum + (float)$payments[$x]->price;
                }
            }else{
                if($new_payment == $previous_payment)
                    for($x=0; $x<sizeof($balance); $x++){
                        $sum = (float)$balance[$x]->balance;
                    }
                else{ 
                    $sum = $new_payment - $previous_payment;
                }
            };

            $paymentshistory = DB::table('payments_table')
            ->where([['stud_id', '=', $id], ['academic_year', '=', $ay[0]->academic_year], ['semester', '=', 1]])->get();

            $optionalPaymentsHistory = DB::table('optional_records')
            ->where([['stud_id', '=', $id], ['academic_year', '=', $ay[0]->academic_year], ['semester', '=', 1]])->get();

            return view('transaction', array('students' => $student, 'payments' => $sum, 'histories' => $paymentshistory, 'optionals' => $opt_payments, 'optionalHistories' => $optionalPaymentsHistory, 'acadyears' => $ay));
        }else if(sizeof($student) > 0 && $acad_year != null && $semester != null){   
            $payments = DB::table('item_lists')
            ->where('Status', '=', 'mandatory')->get();

            $opt_payments = DB::table('item_lists')
            ->where('Status', '=', 'optional')->get();

            $balance = DB::table('payments_table')
            ->where([['stud_id', '=', $id], ['academic_year', '=', $acad_year], ['semester', '=', $semester]])->get();

            // $balance = DB::table('payments_table')
            // ->where([['stud_id', '=', $id], ['academic_year', '=', $ayget], ['semester', '=', $sem]])->get();

            for($x=0; $x<sizeof($payments); $x++){
                $new_payment = $new_payment + (float)$payments[$x]->price;
            }
            for($x=0; $x<sizeof($balance); $x++){
                $previous_payment = $previous_payment + (float)$balance[$x]->total;
            }

            if(sizeof($balance) == 0){
                for($x=0; $x<sizeof($payments); $x++){
                    $sum = $sum + (float)$payments[$x]->price;
                }
            }else{
                if($new_payment == $previous_payment)
                    for($x=0; $x<sizeof($balance); $x++){
                        $sum = (float)$balance[$x]->balance;
                    }
                else{ 
                    $sum = $new_payment - $previous_payment;
                }
            };

            $paymentshistory = DB::table('payments_table')
            ->where([['stud_id', '=', $id], ['academic_year', '=', $acad_year], ['semester', '=', $semester]])->get();

            $optionalPaymentsHistory = DB::table('optional_records')
            ->where([['stud_id', '=', $id], ['academic_year', '=', $acad_year], ['semester', '=', $semester]])->get();

            return view('transaction', array('students' => $student, 'payments' => $sum, 'histories' => $paymentshistory, 'optionals' => $opt_payments, 'optionalHistories' => $optionalPaymentsHistory, 'acadyears' => $ay));
        }else return view('transaction', array('students' => '', 'payments' => 0, 'histories' => '', 'optionalHistories' => '', 'acadyears' => $ay, 'optionals' => $opt_payments));
    }

    //Insert transactions to the database
    //to generate a receipts

    public function insertpayment(Request $request){
        $sum = (float) 0;
        $sumPayment = (float) 0;
        $this->validate($request, [
            'student_id' => 'required|max:255',
            'semester' => 'required|max:255',
            'cashchange' => 'required|max:255',
            'cashamount' => 'required|max:255',
            'academicYear' => 'required',
        ]);

        $optional = $request->input("optional");

        if(sizeof($optional) > 0){
            for($x = 0; $x < sizeof($optional); $x++){
                $tmp1 = explode('-', $optional[$x]);

                $tmp = [
                    'stud_id' => $request->student_id,
                    'semester' => $request->semester,
                    'account' => $tmp1[0],
                    'total' => (float)$tmp1[1],
                    'size' => "temp",
                    'academic_year' => $request->academicYear,
                    'cashier' => Auth::user()->position,
                    'created_at'=>date('Y-m-d H:i:s'),
                ];

                DB::table('optional_records')
                ->insert($tmp);    
                echo json_encode($request->academicYear);
            }
        }else{            
            $payments = DB::table('item_lists')
            ->where('Status', '=', 'mandatory')->get();

            for($x=0; $x<sizeof($payments); $x++){
                $sumPayment = $sumPayment + (float)$payments[$x]->price;
            }        

            $payment = [
                        'stud_id' => $request->student_id,
                        'semester' => $request->semester,
                        'balance' => $request->cashchange,
                        'total' => $request->cashamount,
                        'academic_year' => $request->academicYear,
                        'cashier' => Auth::user()->position,
                        'created_at'=>date('Y-m-d H:i:s'),
                      ];

            DB::table('payments_table')
            ->insert($payment);

            echo json_encode($request->academicYear);
        }

        // echo json_encode($tmp);
    }

    /* Used to calculate number of students
     that are fully paid, partial, and unpaid.
     It displays a pie graph using the data collected*/

    public function pie_graph(){
        $paid = 0;
        $unpaid = 0;
        $partial = 0;
        $payment = 0;

        $payments = DB::table('item_lists')
            ->where('Status', '=', 'mandatory')->get();

        for($x=0; $x<sizeof($payments); $x++){
            $payment = $payment + (float)$payments[$x]->price;
        }

        $graphStats = DB::select("select status, count(status) as count from (select case when sum(total) = $payment then 'paid' when 
            sum(total) > 0 AND sum(total) < $payment then 'partial' else 'unpaid' end as status from payments_table a right join 
            (select * from students) b on a.stud_id = b.Student_no group by student_no) tmp group by status");

        for($x=0; $x<sizeof($graphStats); $x++){
            if($graphStats[$x]->status == "paid"){
                $paid = $graphStats[$x]->count;
            }else if($graphStats[$x]->status == "unpaid"){
                $unpaid = $graphStats[$x]->count;
            }else $partial = $graphStats[$x]->count;
        }

        $stats = [
                    'Unpaid' => $unpaid,
                    'Paid' => $paid,
                    'Partial' => $partial,
                  ];

        return $stats;
    }

    public function acadYear(Request $request){
        $this->validate($request, [
            'acad_year' => 'required|max:255',
        ]);

        $ay = [
                  'academic_year' => $request->acad_year,
              ];

            DB::table('academic_year')
            ->insert($ay);
    }

    public function invoice($options = null, $or = null, $acad = null, $sem = null){
        $paymentshistory = DB::table('payments_table')
        ->where('or_no', '=', $or)
        ->limit(1)->get();

        if(sizeof($paymentshistory) > 0 && $options == "mandatory"){
            $totalprevamount = 0;     

            $stud_id = $paymentshistory[0]->stud_id;

            $previous_payment = DB::table('payments_table')
            ->where([['or_no', '<', $or], ['stud_id', '=', $stud_id], ['academic_year', '=', $acad], ['semester', '=', $sem]])->get();

            $stud_info = DB::table('students')
            ->where('Student_No', '=', $stud_id)
            ->limit(1)->get();

            $records = [
                        'OR' => $paymentshistory[0]->or_no,
                        'Name' => $stud_info[0]->Student_Name,
                        'Date' => $paymentshistory[0]->created_at,
                        'Semester' => $paymentshistory[0]->semester,
                        'Course' => $stud_info[0]->Course,
                        'Cashier' => $paymentshistory[0]->cashier,
                        'Year' => $stud_info[0]->Year,
                        'academic_year' => $paymentshistory[0]->academic_year,
                      ];

            $accounts = DB::table('item_lists')
            ->where('Status', '=', 'mandatory')->get();

            $arrPayment = [];
            $amount = $paymentshistory[0]->total;

            for($x=0; $x<sizeof($previous_payment); $x++){
                $totalprevamount = $totalprevamount + (float)$previous_payment[$x]->total;            
            }

            for($x=0; $x<sizeof($accounts); $x++){
                if(sizeof($previous_payment) > 0){
                    if($totalprevamount >= $accounts[$x]->price){
                        $arrPayment[$x]['payment'] = 0;
                        $totalprevamount = $totalprevamount - $accounts[$x]->price;
                    }else{
                        $arrPayment[$x]['payment'] = $totalprevamount;
                        $totalprevamount = $totalprevamount - $totalprevamount;
                        $tmp = $amount+$arrPayment[$x]['payment'];
                        if($tmp >= $accounts[$x]->price){
                            $arrPayment[$x]['payment'] = $accounts[$x]->price - $arrPayment[$x]['payment'];
                            $amount = $amount - $arrPayment[$x]['payment'];
                        }else{
                            $arrPayment[$x]['payment'] = $amount;
                            $amount = $amount - $amount;
                        }
                    }                
                }else{
                    if($amount >= $accounts[$x]->price){
                        $arrPayment[$x]['payment'] = $accounts[$x]->price;
                        $amount = $amount - $accounts[$x]->price;
                    }else{
                        $arrPayment[$x]['payment'] = $amount;
                        $amount = $amount - $amount;
                    }
                }
            }

            $data = [$records, 'accounts' => $accounts, 'data' => $arrPayment];
            
            return view("invoice", compact('data'));
        }else if($options == "optional"){
            $previous_payment = DB::table('optional_records')
            ->where([['or_no', '=', $or], ['academic_year', '=', $acad], ['semester', '=', $sem]])->get();

            $stud_info = DB::table('students')
            ->where('Student_No', '=', $previous_payment[0]->stud_id)
            ->limit(1)->get();

            $records = [
                        'OR' => $previous_payment[0]->or_no,
                        'Name' => $stud_info[0]->Student_Name,
                        'Date' => $previous_payment[0]->created_at,
                        'Semester' => $previous_payment[0]->semester,
                        'Course' => $stud_info[0]->Course,
                        'Cashier' => $previous_payment[0]->cashier,
                        'Year' => $stud_info[0]->Year,
                        'academic_year' => $previous_payment[0]->academic_year,
                      ];

            $accounts = DB::table('item_lists')
            ->where('Status', '=', 'optional')->get();

            $arrPayment[0]['payment'] = $previous_payment[0]->total;
            $data = [$records, 'accounts' => $accounts, 'data' => $arrPayment];

            return view("invoice", compact('data'));
        }else return view("error_layout.error");
    }

public function postContact(Request $request, $options = null, $or = null){
    // $data = Twitter::getUserTimeline(['user_id' => $provider, 'format' => 'array']);
    // $this->pdf = PDF::loadView('pdf',compact('data'));

    $this->validate($request,[
        'email'=>'required|email']);

    //echo json_encode($request->email . " dsadsda " . $options. " dsadsda " . $or);
    return $this->or_pdf($options, $or);

    // $datani=array(
    //     'email'=>$request->email,
    //     'subject'=>$request->subject,
    //     'bodyMessage'=>$request->message);

    // Mail::send('email',$datani,function($message)use($datani){        
        
    //     $message->from('iclocalcouncil@gmail.com','ICLC');
    //     $message->to($datani['email']);
    //    // $message->attachData($this->pdf->output(),'twitter.pdf');
    //     $message->subject($datani['subject']);

    // }); 
    // Session::flash('Success',' Message was sent!');
}

public function tempFilter($sem = null, $acadyear = null, $id = null){
    return $this->transaction($id, $acadyear, $sem);
}

public function data_checker($year, $sem, $acadyear, $course)
    {
        $overallamount = 0;
        if($year == "All")$year = "%";
        if($course == "All")$course = "%";
        if($acadyear == "All"){
            $acadyear = "%";
            $overallamount = 0;
        }else{
            $overallamount = 0;

            $users = DB::select("select b.*, coalesce($overallamount + sum(total), $overallamount) as 'status' from payments_table a right join
                (select * from students) b on a.stud_id = b.Student_no where year like '".$year."' and course like '".$course."' and academic_year like '%$acadyear%' group by academic_year, semester, stud_id");

            if($sem != "All"){    
                $overallamount = 0;
                $users = DB::select("select b.*, coalesce($overallamount + sum(total), $overallamount) as 'status' from payments_table a right join
                    (select * from students) b on a.stud_id = b.Student_no where year like '".$year."' and course like '".$course."' and academic_year like '%$acadyear%' and semester like '%$sem%' group by academic_year, stud_id, semester");
            }

        return $users;
        }
        
        $users = DB::select("select b.*, coalesce($overallamount + sum(total), $overallamount) as 'status' from payments_table a right join
                (select * from students) b on a.stud_id = b.Student_no where year like '".$year."' and course like '".$course."' group by student_no;");

        return $users;
    }

    public function query()
    {
        $overallamount = 0;

        $year = DB::select('select year from students group by year');
        $users = DB::select("select b.*, coalesce($overallamount + sum(total), $overallamount) as 'status' from payments_table a right join
                (select * from students) b on a.stud_id = b.Student_no group by student_no;");
        $course = DB::select('select course from students group by course');
        $items = DB::select('select * from item_lists');
        $academic_years = DB::select('select * from academic_year');

        return view('reports', ['students' => $users, 'yearlevels' => $year, 'courses' => $course, 'items' => $items, 'academic_years' => $academic_years]);
    }

    public function filter($year = null, $sem = null, $acadyear = null, $course = null)
    {
        $data = $this->data_checker($year, $sem, $acadyear, $course);
        return Response::json($data);
    }

    public function csv($year = null, $sem = null, $acadyear = null, $course = null)
    {   
            $mad = new HomeController;
            $data = $mad->data_checker($year, $sem, $acadyear, $course);
            $data = json_decode(json_encode($data), true);

            print_r($data);
            // Excel::create('ICLC_Report', function($excel) use ($data){
            //     $excel->sheet('Sheet 1', function($sheet) use ($data) {
            //         $sheet->fromArray($data);
            //     });
            // })->export('xls');
    }

    public function or_pdf($or = null, $options = null) {


        if($options == "mandatory"){
                $paymentshistory = DB::table('payments_table')
                ->where('or_no', '=', $or)
                ->limit(1)->get();
                $filename = 'OR#'.$or;
        }else{
                $paymentshistory = DB::table('optional_records')
                ->where('or_no', '=', $or)
                ->limit(1)->get();
                $filename = 'OR#'.'OP'.$or;
        }

            $totalprevamount = 0;        

            $stud_id = $paymentshistory[0]->stud_id;

            $previous_payment = DB::table('payments_table')
            ->where([['or_no', '<', $or], ['stud_id', '=', $stud_id]])->get();

            $stud_info = DB::table('students')
            ->where('Student_No', '=', $stud_id)
            ->limit(1)->get();

            $records = [
                        'OR' => $paymentshistory[0]->or_no,
                        'Name' => $stud_info[0]->Student_Name,
                        'Date' => $paymentshistory[0]->created_at,
                        'Semester' => $paymentshistory[0]->semester,
                        'Course' => $stud_info[0]->Course,
                        'Cashier' => $paymentshistory[0]->cashier,
                        'Year' => $stud_info[0]->Year,
                      ];

            $accounts = DB::table('item_lists')
            ->where('Status', '=', 'mandatory')->get();

            $arrPayment = [];
            $amount = $paymentshistory[0]->total;

            for($x=0; $x<sizeof($previous_payment); $x++){
                $totalprevamount = $totalprevamount + (float)$previous_payment[$x]->total;            
            }

            for($x=0; $x<sizeof($accounts); $x++){
                if(sizeof($previous_payment) > 0){
                    if($totalprevamount >= $accounts[$x]->price){
                        $arrPayment[$x]['payment'] = 0;
                        $totalprevamount = $totalprevamount - $accounts[$x]->price;
                    }else{
                        $arrPayment[$x]['payment'] = $totalprevamount;
                        $totalprevamount = $totalprevamount - $totalprevamount;
                        if($amount >= $accounts[$x]->price){
                            $arrPayment[$x]['payment'] = $accounts[$x]->price - $arrPayment[$x]['payment'];
                            $amount = $amount - $arrPayment[$x]['payment'];
                        }else{
                            $arrPayment[$x]['payment'] = $arrPayment[$x]['payment'] + $amount;
                            $amount = $amount - $amount;
                        }
                    }                
                }else{
                    if($amount >= $accounts[$x]->price){
                        $arrPayment[$x]['payment'] = $accounts[$x]->price;
                        $amount = $amount - $accounts[$x]->price;
                    }else{
                        $arrPayment[$x]['payment'] = $amount;
                        $amount = $amount - $amount;
                    }
                }
            }

        $data = [$records, 'accounts' => $accounts, 'data' => $arrPayment];
        $pdf = PDF::loadView('template.receipt', compact('data'));
        return $pdf->download($filename);
    }

    public function pdf($year = null, $sem = null, $acadyear = null, $course = null)
    {
        $data = $this->data_checker($year, $sem, $acadyear, $course);
        $pdf = PDF::loadView('pdfReport', compact('data'));
        return $pdf->stream("ICLC_Report.pdf");
    }

}
