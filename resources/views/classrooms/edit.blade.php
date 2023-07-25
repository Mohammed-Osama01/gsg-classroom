@extends('layouts.master')

@section('title', 'Edit Classroom' . $classroom->name)
@section('content')

    <!-- body-->
    <div class="container mt-5">
        <h1>Edit Classroom</h1>

        <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Form Method Sppofing --}}
            {{-- <input type="hidden" name="_method" value="put"> --}}
            {{-- {{ method_field('put') }} --}}
            @method('put')

            @include('classrooms._form', [
                'button_label' => 'Update Classroom',
            ])
        </form>
    </div>




@endsection
