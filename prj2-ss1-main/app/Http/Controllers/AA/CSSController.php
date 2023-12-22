<?php

namespace App\Http\Controllers\AA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CSSController extends Controller{

    function index(){
        $class_subject_students = DB::table('class_subject_students')
            ->join('users', 'class_subject_students.id', '=', 'users.id')
            ->join('class_subjects', 'class_subject_students.cs_id', '=', 'class_subjects.cs_id')
            ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
            ->join('majors', 'subjects.major_id', '=', 'majors.major_id' )
            ->select('users.name as name','users.student_code as student_code','class_subject_students.*', 'class_subjects.*' , 'classes.*', 'subjects.*', 'majors.*')

            ->paginate(10);
        $majors = DB::table('majors')->get();
        $users = DB::table('users')
            ->join('classes', 'users.class_id', '=', 'classes.class_id')
            ->where('users.role', '=', 0)
            ->get();
        $subjects = DB::table('subjects')
            ->join('majors', 'subjects.major_id', '=', 'majors.major_id' )
            ->select('majors.*', 'subjects.*')
            ->get();
        $classes = DB::table('classes')->get();
        $class_subjects = DB::table('class_subjects')
            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
            ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
            ->join('majors', 'subjects.major_id', '=', 'majors.major_id')
            ->select('class_subjects.*','subjects.*','classes.*', 'majors.*')
            ->get();
        return view('academic_affairs.class-subject-student.index',
            ['class_subject_students' => $class_subject_students,
                'users' => $users, 'class_subjects'=> $class_subjects, 'classes' => $classes,'subjects' => $subjects, 'majors' => $majors]);
    }

    function createCSS(Request $request){
        $name = $request->input('name');
        $subject_name = $request->input('subject_name');
//        $validator = Validator::make($request->all(), [
//            'name' => [
//                'required',
//                Rule::unique('class_subject_students', 'id'),
//            ],
//            'subject_name' => [
//                'required',
//                Rule::unique('class_subject_students', 'cs_id'),
//            ],
//        ]);
//        if ($validator->fails()) {
//            flash()->addError('CSS đã được thêm!');
//            return redirect()->back()->withErrors($validator)->withInput();
//        }
        $result = DB::table('class_subject_students')
            ->join('users', 'class_subject_students.id', '=', 'users.id')
            ->join('class_subjects', 'class_subject_students.cs_id', '=', 'class_subjects.cs_id')
            ->select('class_subject_students.*', 'users.*','class_subjects.*')
            ->insert([
                'id' => $name,
                'cs_id' => $subject_name,
            ]);

        if($result){
            flash()->addSuccess('Thêm thành công!');
            return redirect()->route('aa-css');
        }else {
            flash()->addError('Thêm thất bại!');
            return redirect()->route('aa-css');
        }
    }
}
