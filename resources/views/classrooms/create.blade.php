@extends('layouts.master')

@section('title','Create Classrooms')
@section('content')

    <!-- body-->
    <div class="container mt-5">
        <h1>create Classroom</h1>

        <form action="{{route('classrooms.store') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            {{ csrf_field()}}
            @csrf
            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="name" placeholder="Class Name">
                <label for="name">Class Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="section" class="form-control" id="section" placeholder="Section">
                <label for="section">Section</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject">
                <label for="subject">Subject</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="room" class="form-control" id="room" placeholder="Room">
                <label for="room">Room</label>
            </div>
            <div class="form-floating mb-3">
                <input type="file" name="cover_image" class="form-control" id="cover_image" placeholder="Cover Image">
                <label for="Cover_Image">Cover Image</label>
            </div>
            <button type="submit" class="btn btn-primary">Create Room</button>
        </form>
    </div>




    @endsection
