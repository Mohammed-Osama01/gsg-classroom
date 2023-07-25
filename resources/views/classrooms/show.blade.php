@extends('layouts.master')

@section('title', $classroom->name)
@section('content')
<!-- body-->
<div class="container">
    <h1 style="position:absolute; top:150px;z-index:10; " class="p-5">{{$classroom->name}}(#{{$classroom->id}})</h1>
    <h3 style="position:absolute; top:220px;z-index:10;" class="p-5">{{ $classroom->section }}</h3>
    <div class="card mt-3" style="border-radius:22px">
        <img src="{{asset('uploads/' . $classroom->cover_image_path) }}" style="border-radius:15px" width="150px" height="240px" class="card-img-top" alt="...">
    </div>
    <div class="row mt-4">
        <div class="col-md-2">
            <div class="border rounded p-3 text-center">
                <span class="text-success fs-2">{{$classroom->code}}</span>
                <p class="text-muted">Woohoo, no work due soon!</p>
            </div>
        </div>
        <div class="col-md-9">
            f
        </div>
    </div>
    @endsection
