<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Response;

class Student_Controller extends Controller
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
        $data = $this->retrieve('course');

        return view('pages/student', array('course' => $data));
    }

    public function student_list()
    {
    	$data = array();
        //join balance and student information table;
        $student = $this->retrieve('student');
        
        if($student){
        	foreach ($student as $key => $value) {
                $data[$key][] = $student[$key]->id;
	            $data[$key][] = $student[$key]->student_number;
	            $data[$key][] = $student[$key]->first_name." ".$student[$key]->last_name;
	            //$data[$key][] = $student[$key]->Gender;
	            $data[$key][] = $student[$key]->year;
                $data[$key][] = '<div class="btn-group"><button type="submit" class="btn btn-info" id="update-student-button" data-id="'.$student[$key]->id.'">
                <i class="fa fa-lg fa-edit"></i></button><button type="submit" class="btn btn-warning" id="delete-student-button" data-id="'.$student[$key]->id.'">
                <i class="fa fa-lg fa-trash"></i></button></div>';
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

    public function student(Request $request, $option = null){
    	if($option === 'add'){
	         $this->validate($request, [
	            'studNum' => 'required|max:255',
                'firstName' => 'required|max:255',
                'middleName' => 'required|max:255',
	            'lastName' => 'required|max:255',
	            'studYear' => 'required|max:255',
	            'studCourse' => 'required|max:255',
	            'studGender' => 'required|max:255',
	        ]);

	        $data = [
                'student_number' => $request->studNum,
                'first_name' => ucwords($request->firstName),
                'last_name' => ucwords($request->lastName),
                'year'=>$request->studYear,
                'course_id'=>$request->studCourse,
	        ];
	        
            $insert = DB::table('student')
            ->insert($data);

            echo json_encode($insert);
    	}
    }

    public function retrieve($table){
        $data = array();

        if($table === 'student'){
            return $data = DB::table($table)->get();
        }else if($table === 'course'){
            return $data = DB::table($table)->get();
        }
    }

    public function search_by_id(Request $request){
        $search = [
            'id' => $request->id,
        ];

        if($search['id']){
            $user = DB::table('student')->where('student_number', $search['id'])->first();
            if($user){
                $result = array(
                    'info' => $user,
                    'status' => 'exists'
                    );

                echo json_encode($result);
            }
            else{
                $result = array(
                    'status' => 'not exists'
                    );

                echo json_encode($result);
            }
        }else{
            $result = array(
                'status' => false
                );

            echo json_encode($result);
        }
    }
}
