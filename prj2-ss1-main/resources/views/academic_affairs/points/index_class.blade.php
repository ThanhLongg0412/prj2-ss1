@extends('layouts.app')

@section('content')
    <form action="{{ route('aa-point-class-search') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Tìm kiếm</span>
            <input value="{{ $keyword ?? '' }}" autocomplete=off name="keyword" type="text" class="form-control" placeholder="Nhập từ khóa" aria-label="Username" aria-describedby="basic-addon1">
        </div>
        <button type="submit" hidden></button>
    </form>
    <div class="row">
        @foreach($classes as $class)
            <div class="col-lg-2">
                <div class="card card-chart">
                    <div class="card-header">
                        <form action="{{ route('aa-point-subject') }}" method="GET">
                            @csrf
                            <input name="class_id" hidden value="{{ $class->class_id }}">
                            <button class="btn btn-primary">{{ $class->class_name }}K{{ $class->school_year }}</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
