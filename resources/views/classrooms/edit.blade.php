@extends('layouts.master')

@section('title','Edit Classroom'. $classroom->name)
@section('content')

<!-- body-->
<div class="container mt-5">
    <h1>Edit Classroom</h1>

    <form action="{{route('classrooms.update',$classroom->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <!--Form Method Spoofing -->
        {{-- <input type="hidden" name="_method" value="put">
                {{ method_field('put')}}
        --}}

        @method('put')

        <div class="form-floating mb-3">
            <input type="text" name="name" class="form-control" value="{{$classroom->name}}" id="name" placeholder="Class Name">
            <label for="name">Class Name</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="section" class="form-control" value="{{$classroom->section}}" id="section" placeholder="Section">
            <label for="section">Section</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="subject" class="form-control" value="{{$classroom->subject}}" id="subject" placeholder="Subject">
            <label for="subject">Subject</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="room" class="form-control" value="{{$classroom->room}}" id="room" placeholder="Room">
            <label for="room">Room</label>
        </div>
        <div class="form-floating mb-3">
            <input  src="uploads/{{ $classroom->cover_image_path}}"type="file" name="cover_image" class="form-control" id="cover_image" placeholder="Cover Image">
            <label for="Cover_Image">Cover Image</label>
        </div>

        @if ($classroom->cover_image_path)
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="delete_cover_image" id="delete_cover_image">
                <label class="form-check-label" for="delete_cover_image">
                    Delete Cover Image
                </label>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Update Room</button>
    </form>
</div>




@endsection
