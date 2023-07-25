@extends('layouts.master')

@section('title', 'Create Classrooms')
@section('content')

    <!-- body-->
    <div class="container mt-5">
        <h1>create Classroom</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }} </li>
                    @endforeach
                </ul>
            </div>

        @endif
        <form action="{{ route('classrooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- {{ csrf_filed() }} --}}
            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
            @include('classrooms._form', [
                'button_label' => 'Create Room',
            ])

        </form>

    </div>




@endsection
