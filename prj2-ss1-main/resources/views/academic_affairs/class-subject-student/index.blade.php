@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <button class="btn btn-primary mb-3" data-coreui-toggle="modal" data-coreui-target="#staticBackdrop1">Thêm
                lớp</button>
            <table class="table table-striped table-responsive table-bordered">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sinh viên</th>
                    <th>Mã sinh viên</th>
                    <th>Tên lớp môn học</th>
                    <th>Lần thi</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($class_subject_students as $css)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $css->name }}</td>
                        <td>{{ $css->student_code }}</td>
                        <td>{{ $css->class_name}}K{{ $css->school_year }}-{{ $css->subject_name }}</td>
                        <td>{{ $css->exam_times }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Không có lớp môn học</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
             {{ $class_subject_students->links() }}
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop1" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Thêm lớp môn học</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('aa-css-create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="modal-body">
                            <select name="name" style="margin-top: 20px" required >
                                <option >Chọn sinh viên</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}-{{ $user->student_code }}-{{ $user->class_name }}K{{ $user->school_year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-body">
                            <select name="subject_name" style="margin-top: 20px"  required>
                                <option >Chọn lớp môn học</option>
                                @foreach($class_subjects as $class_subject)
                                    <option value="{{ $class_subject->cs_id }}">{{ $class_subject->class_name }}K{{ $class_subject->school_year }} -
                                        {{ $class_subject->subject_name }} Lần
                                        -{{ $class_subject->exam_times }} - {{ $class_subject->major_name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
