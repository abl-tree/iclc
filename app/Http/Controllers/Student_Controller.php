<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Excel;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

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
	            $data[$key][] = $student[$key]->name;
                $data[$key][] = $student[$key]->gender;
	            $data[$key][] = $student[$key]->course;
	            $data[$key][] = $student[$key]->year;
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
	            'studYear' => 'required|max:255',
	            'studCourse' => 'required|max:255',
	            'studGender' => 'required|max:255',
	        ]);

	        $data = [
                'student_number' => $request->studNum,
                'name' => ucwords($request->firstName),
                'year'=>$request->studYear,
                'course_id'=>$request->studCourse,
                'gender'=>$request->studGender,
	        ];
	        
            $insert = DB::table('student')
            ->insert($data);

            echo json_encode($insert);
    	}else if($option === 'upload'){
            $this->upload();
        }else if($option === 'update'){
            $this->validate($request, [
                'student_id' => 'required|max:255',
                'update-studNum' => 'required|max:255',
                'update-studName' => 'required|max:255',
                'update-studCourse' => 'required|max:255',
                'update-studYear' => 'required|max:255',
                'update-studGender' => 'required|max:255',
            ]);

            $data = array(
                'student_number' => $request['update-studNum'], 
                'name' => $request['update-studName'], 
                'course_id' => $request['update-studCourse'], 
                'year' => $request['update-studYear'], 
                'gender' => $request['update-studGender']
            );

            $result = DB::table('student')
                    ->where('id', $request->student_id)
                    ->update($data);

            echo json_encode($result);
        }else if($option === 'delete'){
            $this->validate($request, [
                'student_id' => 'required|max:255'
            ]);

            $student_id = array_map('intval', explode(',', $request->student_id));

            $student = DB::table('student')
                        ->whereIn('id', $student_id)
                        ->delete();

            echo json_encode($student);
        }
    }

    public function retrieve($table){
        $data = array();

        if($table === 'student'){
            return $data = DB::table('student as a')
                            ->select('a.*', 'b.name as course')
                            ->join('course as b', 'a.course_id', '=', 'b.id')
                            ->get();
        }else if($table === 'course'){
            return $data = DB::table($table)->get();
        }
    }

    public function search_by_id_number(Request $request){
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

    public function search_by_id($id){
        $student = DB::table('student')
            ->where('id', $id)
            ->get();

        echo json_encode($student);
    }

    public function upload(){
        $absolute_path = realpath($_FILES['excel']['tmp_name']);
        $extension = pathinfo($_FILES['excel']['name'], PATHINFO_EXTENSION);

        // $data = Excel::selectSheets('Sheet1')->load($absolute_path);

        // echo json_encode($data);
        Excel::load($absolute_path, function($reader) {
            $data = array();
            $saved = 0;
            // reader methods
            foreach ($reader->toArray() as $key => $value) {  
                $student_number = preg_replace('/\s+/', '', $value['student_number']);

                if($student_number == null){
                    continue;
                }

                $check = DB::table('student')
                ->where('student_number', $student_number)
                ->first();

                $courseID = DB::table('course')
                ->select('id')
                ->where('name', $value['program'])
                ->first();

                if(!$courseID){
                    $course_data = array('name' => $value['program']);
                    $courseID = DB::table('course')
                            ->insertGetId($course_data);
                }else $courseID = $courseID->id;

                if(!$check){
                    $saved += 1;
                    $data[$key]['student_number'] = $student_number;
                    $data[$key]['name'] = $value['student_name'];
                    $data[$key]['gender'] = $value['gender'];
                    $data[$key]['year'] = $value['year'];
                    $data[$key]['course_id'] = $courseID;
                    // $data[$key][] = $value['home_address'];
                }
            }
            
            if($data){
                $insert = DB::table('student')
                ->insert($data);

                echo json_encode($saved);
                return true;            
            }else{
                echo json_encode($saved);
                return true;
            }
            // Loop through all sheets
            // $reader->each(function($sheet){
            //     // return $sheet;
            //     // Loop through all rows
            //     $sheet->each(function($row) {
            //         return $row;
            //     });
            // });
        });
    }

    public function delete(){
        $users = DB::table('users')
                    ->whereIn('id', [1, 2, 3])
                    ->get();
    }
}
