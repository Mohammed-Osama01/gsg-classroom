@extends('layouts.master')

@section('title', 'Classrooms')
@section('content')
    <div class="container">
        <h1>Classrooms</h1>
        <a href="{{ route('classrooms.create') }}" class="btn btn-primary px-3 my-2">Create <i
                class="fa-solid fa-plus"></i></a>

        <x-alert name="success" class="alert-success" />
        <x-alert name="error" id="error" class="alert-danger" />
        <div class="row">


            @foreach ($classrooms as $classroom)
                <div class="col-md-3">
                    <div class="card mt-3">
                        {{-- <img src="{{asset('uploads/' . $classroom->cover_image_path) }}" width="150px" height="120px" class="card-img-top" alt="..."> --}}
                        <img src="/storage/{{ $classroom->cover_image_path }}" width="150px" height="120px"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $classroom->name }}</h5>
                            <p class="card-text">{{ $classroom->section }}-{{ $classroom->room }}</p>
                            <a href="{{ route('classrooms.show', $classroom->id) }}"
                                class="btn btn-small btn-primary">View</a>
                            <a href="{{ route('classrooms.edit', $classroom->id) }}" class="btn btn-small btn-dark">Edit</a>
                            <form class="d-inline" action="{{ route('classrooms.destroy', $classroom->id) }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-small btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endsection

@push('scripts')
