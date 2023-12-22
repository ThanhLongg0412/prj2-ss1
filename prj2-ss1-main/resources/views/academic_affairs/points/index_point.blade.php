@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Danh sách điểm của sinh viên</h1>
            @foreach($class_subjects as $class_subject)
                <h3>Lớp {{ $class_subject->class_name}}K{{ $class_subject->school_year}} - Môn {{ $class_subject->subject_name}} Lần {{ $class_subject->exam_times}} - {{ $class_subject->ep_name}}</h3>
            @endforeach
            <p style="color: red">Chú ý: * Điểm của sinh viên có thể được nhập bằng cách nhấp vào ô điểm và nhập điểm.<br>
                * Đối với các môn ASM, điểm dưới 5 tương đương với điểm F, dưới 8 tương đương với P, dưới 10 là M và bằng 10
                là D.<br>
                * Đối với các môn BTEC, chỉ có thể nhập điểm ASM, còn với môn CĐN Bách Khoa, chỉ có thể nhập điểm Lý thuyết và Thực hành.<br>
            </p>
            <button class="btn btn-primary mb-3" data-coreui-toggle="modal" data-coreui-target="#staticBackdrop1">Thêm sinh viên</button>

            <table class="table table-striped table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sinh viên</th>
                        <th>Mã sinh viên</th>
                        <th>Lý thuyết</th>
                        <th>Thực hành</th>
                        <th>ASM</th>
                        <th>Kết quả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($points as $point)
                        @if ($point->ep_id == 1)
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $point->name }}</td>
                        <td>{{ $point->student_code }}</td>
                        <td contenteditable="false" class="editable" data-field="theory" oninput="checkMinMax(this, 0, 10)">
                            {{ $point->theory }}</td>
                        <td contenteditable="false" class="editable" data-field="practice"
                            oninput="checkMinMax(this, 0, 10)">{{ $point->practice }}</td>
                        <td contenteditable="true" class="editable" data-field="asm" oninput="checkMinMax(this, 0, 10)">
                            @php
                                $asmGrade = '';
                                $asm = $point->asm;
                                if ($asm === null) {
                                    $asmGrade = '';
                                } else {
                                    $asm = (int) $asm;

                                    switch ($asm) {
                                        case $asm < 5:
                                            $asmGrade = 'F';
                                            break;
                                        case $asm < 8:
                                            $asmGrade = 'P';
                                            break;
                                        case $asm < 10:
                                            $asmGrade = 'M';
                                            break;
                                        case $asm === 10:
                                            $asmGrade = 'D';
                                            break;
                                        default:
                                            flash()->addError('Thêm thất bại!');
                                            break;
                                    }
                                }
                            @endphp
                            {{ $asmGrade }}
                        </td>
                        <td>
{{--                            {{ $point->result == 1 ? 'Qua môn' : 'Trượt' }}--}}
                            @if ($point->exam_times == 1)
                                {{ $point->result == 1 ? 'Qua môn' : 'Thi lần 2' }}
                            @elseif ($point->exam_times == 2)
                                {{ $point->result == 1 ? 'Qua môn' : 'Học lại' }}
                            @else {{ $point->result == 1 ? 'Qua môn' : 'Học lại' }}
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-primary" onclick="saveData(this)"
                                    data-point-id="{{ $point->point_id }}">Lưu</button>
                        </td>
                        </tr>

                        @else
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $point->name }}</td>
                        <td>{{ $point->student_code }}</td>
                        <td contenteditable="true" class="editable" data-field="theory" oninput="checkMinMax(this, 0, 10)">
                            {{ $point->theory }}</td>
                        <td contenteditable="true" class="editable" data-field="practice"
                            oninput="checkMinMax(this, 0, 10)">{{ $point->practice }}</td>
                        <td contenteditable="false" class="editable" data-field="asm" oninput="checkMinMax(this, 0, 10)">
                            @php
                                $asmGrade = '';
                                $asm = $point->asm;
                                if ($asm === null) {
                                    $asmGrade = '';
                                } else {
                                    $asm = (int) $asm;

                                    switch ($asm) {
                                        case $asm < 5:
                                            $asmGrade = 'F';
                                            break;
                                        case $asm < 8:
                                            $asmGrade = 'P';
                                            break;
                                        case $asm < 10:
                                            $asmGrade = 'M';
                                            break;
                                        case $asm === 10:
                                            $asmGrade = 'D';
                                            break;
                                        default:
                                            flash()->addError('Thêm thất bại!');
                                            break;
                                    }
                                }
                            @endphp
                            {{ $asmGrade }}
                        </td>
                        <td>
{{--                            {{ $point->result == 1 ? 'Qua môn' : 'Trượt' }}--}}
                            @if ($point->exam_times == 1)
                                {{ $point->result == 1 ? 'Qua môn' : 'Thi lần 2' }}
                            @elseif ($point->exam_times == 2)
                                {{ $point->result == 1 ? 'Qua môn' : 'Học lại' }}
                            @else {{ $point->result == 1 ? 'Qua môn' : 'Học lại' }}
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-primary" onclick="saveData(this)"
                                    data-point-id="{{ $point->point_id }}">Lưu</button>
                        </td>
                        </tr>

                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop1" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Thêm lớp</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('aa-point-css') }}" method="GET">
                    @csrf
                    <div class="modal-body">
                        <select name="css" style="margin-top: 20px" required>
                            <option>Chọn CSS</option>
                            @foreach($class_subject_students as $class_subject_student)
                                <option value="{{ $class_subject_student -> css_id }}">{{ $class_subject_student -> name }}-{{ $class_subject_student->student_code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function checkMinMax(element, min, max) {
            var value = parseFloat(element.textContent);
            if (isNaN(value) || value < min || value > max) {
                element.textContent = '';
                alert('Giá trị phải nằm trong khoảng từ ' + min + ' đến ' + max + '!');
            }
        }

        function saveData(button) {
            var row = button.closest('tr');
            var pointId = button.getAttribute('data-point-id');
            var fields = row.querySelectorAll('.editable');
            var data = {
                pointId: pointId,
            };

            fields.forEach(function(field) {
                var fieldName = field.getAttribute('data-field');
                var fieldValue = field.innerText.trim();
                data[fieldName] = fieldValue;
            });

            fetch('/save-point-data', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(function(response) {
                    location.reload();
                })
                .catch(function(error) {

                });
        }
    </script>
@endsection
