@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Bảng điểm của
                @foreach($users as $user)
                    {{ $user->name}}-{{ $user->student_code}}-Lớp {{ $user->class_name}}K{{ $user->school_year}}</h3>
                @endforeach
            </h1>
            <table class="table table-striped table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Môn</th>
                        <th>Lần thi</th>
                        <th>Lý thuyết</th>
                        <th>Thực hành</th>
                        <th>ASM</th>
                        <th>Kết quả</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($points as $point)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $point->subject_name }}</td>
                            <td>{{ $point->exam_times }}</td>
                            <td>{{ $point->theory }}</td>
                            <td>{{ $point->practice }}</td>
                            <td>
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
                                @if ($point->exam_times == 1)
                                    {{ $point->result == 1 ? 'Qua môn' : 'Thi lần 2' }}
                                @elseif ($point->exam_times == 2)
                                    {{ $point->result == 1 ? 'Qua môn' : 'Học lại' }}
                                @else {{ $point->result == 1 ? 'Qua môn' : 'Học lại' }}
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
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
