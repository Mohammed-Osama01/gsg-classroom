@extends('layouts.master')

@section('title', $classroom->name)
@section('edit')
    <a href="{{ route('classrooms.edit', $classroom->id) }}" class="me-3 bg-Secondary rounded-pill ">
        <i class="fa-solid fa-pen-to-square p-2"></i>
    </a>
@endsection
@section('content')
<div class="container">
    <h1 style="position:absolute; top:150px;z-index:10; color:#fff " class="p-5">
        (#{{ $classroom->id }}) {{ $classroom->name }}</h1>
    <h3 style="position:absolute; top:220px;z-index:10;color:#fff" class="p-5">{{ $classroom->section }}</h3>
    <div class="card mt-3" style="border-radius:22px">
        <img src="{{ Storage::url($classroom->cover_image_path) }}"
            style="border-radius:15px" width="150px" height="240px" class="card-img-top" alt="...">
    </div>
    <div class="row mt-4">
        <div class="col-md-2">
            <div class="border rounded p-3 text-center">
                <p class="text-muted mb-0 pb-0">Class Code</p>
                <span class="text-success fs-2">{{ $classroom->code }}</span>
            </div>
        </div>
        <div class="col-md-9">
            <div class="border rounded p-3 text-center">
                <p class="text-muted mb-0 pb-0">assignment</p>
                <span class="text-success fs-2"></span>
            </div>
        </div>
    </div>
    @endsection
