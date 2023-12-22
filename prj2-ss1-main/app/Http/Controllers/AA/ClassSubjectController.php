<?php
//
//namespace App\Http\Controllers\AA;
//
//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
//
//class ClassSubjectController extends Controller{
//
//    function index(){
//        $class_subjects = DB::table('class_subjects')
//        ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
//        ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
//        ->join('majors', 'subjects.major_id', '=', 'majors.major_id')
//        ->select('classes.*', 'subjects.*','class_subjects.*','majors.*' )->paginate(5);
//        $classes = DB::table('classes')->get();
//        $subjects = DB::table('subjects')->get();
//        $majors = DB::table('majors')->get();
//        return view('academic_affairs.classes-subjects.index',
//        ['class_subjects' => $class_subjects, 'classes' => $classes, 'subjects' => $subjects, 'majors' => $majors]);
//    }
//
//    function createClassSubject(Request $request){
//        $class_name = $request->input('class_name');
//        $subject_name = $request->input('subject_name');
//        $result = DB::table('class_subjects')
//        ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
//        ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
//        ->select('classes.*', 'subjects.*','class_subjects.*')->insert([
//            'class_id' => $class_name,
//            'subject_id' => $subject_name,
//        ]);
//        if($result){
//            flash()->addSuccess('Thêm thành công!');
//            return redirect()->route('aa-classes-subjects');
//        }else {
//            flash()->addError('Thêm thất bại!');
//            return redirect()->route('aa-classes-subjects');
//        }
//    }
//
//    function deleteClassSubjectById(Request $request){
//        $cs_id = $request->input('cs_id');
//        $result = DB::table('class_subjects')->where('cs_id', '=', $cs_id)->delete();
//        if($result){
//            flash()->addSuccess('Xóa thành công!');
//            return redirect()->route('aa-classes-subjects');
//        }else {
//            flash()->addError('Xóa thất bại!');
//            return redirect()->route('aa-classes-subjects');
//        }
//    }
//
//    function updateClassSubjectById(Request $request)
//    {
//        $cs_id = $request->input('cs_id');
//        $class_name = $request->input('class_name');
//        $subject_name = $request->input('subject_name');
//        $result = DB::table('class_subjects')
//        ->where('cs_id', '=', $cs_id)
//        ->update([
//            'class_id' => $class_name,
//            'subject_id' => $subject_name,
//        ]);
//        if($result){
//            flash()->addSuccess('Cập nhật thành công!');
//            return redirect()->route('aa-classes-subjects');
//        }else {
//            flash()->addError('Cập nhật thất bại!');
//            return redirect()->route('aa-classes-subjects');
//        }
//    }
//
//
////    function edit(Request $request){
////        $cs_id = $request->input('cs_id');
////        $class_subjects = DB::table('class_subjects')
////        ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
////        ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
////        ->join('majors', 'subjects.major_id', '=', 'majors.major_id')
////        ->select('classes.*', 'class_subjects.*','subjects.*','majors.*')
////        ->where('cs_id', '=', $cs_id)->get();
////        $majors = DB::table('majors')->get();
////        $subjects = DB::table('subjects')->get();
////        $classes = DB::table('classes')->get();
////        return view('academic_affairs.classes-subjects.edit',
////        ['class_subjects' => $class_subjects, 'subjects' => $subjects,'classes' => $classes, 'majors' => $majors]);
////    }
//
////    function edit(Request $request){
////        $cs_id = $request->input('cs_id');
////        $class_subjects = DB::table('class_subjects')
////            ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
////            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
////            ->join('majors', 'subjects.major_id', '=', 'majors.major_id')
////            ->select('classes.*', 'class_subjects.*','subjects.*','majors.*')
////            ->where('cs_id', '=', $cs_id)->get();
////        $majors = DB::table('majors')->get();
////        $subjects = DB::table('subjects')
////            ->join('majors', 'subjects.major_id', '=', 'majors.major_id')
////            ->select('subjects.*', 'majors.*')
////            ->get();
////        $classes = DB::table('classes')->get();
////        return view('academic_affairs.classes-subjects.edit',
////            ['class_subjects' => $class_subjects, 'subjects' => $subjects,'classes' => $classes, 'majors' => $majors]);
////    }
//    function edit(Request $request){
//        $cs_id = $request->input('cs_id');
//        $class_subjects = DB::table('class_subjects')
//            ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
//            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
//            ->join('majors', 'subjects.major_id', '=', 'majors.major_id')
//            ->select('classes.*', 'class_subjects.*','subjects.*','majors.*')
//            ->where('cs_id', '=', $cs_id)->get();
//        $majors = DB::table('majors')->get();
//        $subjects = DB::table('subjects')
//            ->join('majors', 'subjects.major_id', '=', 'majors.major_id')
//            ->select('subjects.*', 'majors.*')
//            ->get();
//        $classes = DB::table('classes')->get();
//        return view('academic_affairs.classes-subjects.edit',
//            ['class_subjects' => $class_subjects, 'subjects' => $subjects,'classes' => $classes, 'majors' => $majors]);
//    }
//}


namespace App\Http\Controllers\AA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClassSubjectController extends Controller
{

    function index()
    {
        $class_subjects = DB::table('class_subjects')
            ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
            ->join('majors', 'subjects.major_id', '=', 'majors.major_id')
            ->select('classes.*', 'subjects.*', 'class_subjects.*', 'majors.*')->paginate(5);
        $classes = DB::table('classes')->get();
        $subjects = DB::table('subjects')->get();
        $majors = DB::table('majors')->get();
        return view('academic_affairs.classes-subjects.index',
            ['class_subjects' => $class_subjects, 'classes' => $classes, 'subjects' => $subjects, 'majors' => $majors]);
    }

    function createClassSubject(Request $request)
    {
        $class_name = $request->input('class_name');
        $subject_name = $request->input('subject_name');
//        $validator = Validator::make($request->all(), [
//            'class_name' => [
//                'required',
//                Rule::unique('class_subjects', 'class_id'),
//            ],
//            'subject_name' => [
//                'required',
//                Rule::unique('class_subjects', 'subject_id'),
//            ],
//        ]);
//        if ($validator->fails()) {
//            flash()->addError('Lớp môn học đã được thêm!');
//            return redirect()->back()->withErrors($validator)->withInput();
//        }
        $result = DB::table('class_subjects')
            ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
            ->select('classes.*', 'subjects.*', 'class_subjects.*')->insert([
                'class_id' => $class_name,
                'subject_id' => $subject_name,
            ]);
        if ($result) {
            flash()->addSuccess('Thêm thành công!');
            return redirect()->route('aa-classes-subjects');
        } else {
            flash()->addError('Thêm thất bại!');
            return redirect()->route('aa-classes-subjects');
        }
    }

    function deleteClassSubjectById(Request $request)
    {
        $cs_id = $request->input('cs_id');
        $result = DB::table('class_subjects')->where('cs_id', '=', $cs_id)->delete();
        if ($result) {
            flash()->addSuccess('Xóa thành công!');
            return redirect()->route('aa-classes-subjects');
        } else {
            flash()->addError('Xóa thất bại!');
            return redirect()->route('aa-classes-subjects');
        }
    }

    function updateClassSubjectById(Request $request)
    {
        $cs_id = $request->input('cs_id');
        $class_name = $request->input('class_name');
        $subject_name = $request->input('subject_name');
        $result = DB::table('class_subjects')
            ->where('cs_id', '=', $cs_id)
            ->update([
                'class_id' => $class_name,
                'subject_id' => $subject_name,
            ]);
        if ($result) {
            flash()->addSuccess('Cập nhật thành công!');
            return redirect()->route('aa-classes-subjects');
        } else {
            flash()->addError('Cập nhật thất bại!');
            return redirect()->route('aa-classes-subjects');
        }
    }

    function edit(Request $request)
    {
        $cs_id = $request->input('cs_id');
        $class_subjects = DB::table('class_subjects')
            ->join('classes', 'class_subjects.class_id', '=', 'classes.class_id')
            ->join('subjects', 'class_subjects.subject_id', '=', 'subjects.subject_id')
            ->join('majors', 'subjects.major_id', '=', 'majors.major_id')
            ->select('classes.*', 'class_subjects.*', 'subjects.*', 'majors.*')
            ->where('cs_id', '=', $cs_id)->get();
        $majors = DB::table('majors')->get();
        $subjects = DB::table('subjects')
            ->join('majors', 'subjects.major_id', '=', 'majors.major_id')
            ->select('subjects.*', 'majors.*')
            ->get();
        $classes = DB::table('classes')->get();
        return view('academic_affairs.classes-subjects.edit',
            ['class_subjects' => $class_subjects, 'subjects' => $subjects, 'classes' => $classes, 'majors' => $majors]);
    }
}
