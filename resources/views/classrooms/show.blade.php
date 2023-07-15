@extends('layouts.master')

@section('title', $classroom->name)
@section('content')
    <!-- body-->
    <div class="container">
    <h1>{{$classroom->name}}(#{{$classroom->id}})</h1>
    <h3>{{ $classroom->section }}</h3>
    <div class="row">
        <div class="col-md-3">
           <div class="border rounded p-3 text-center">
            <span class="text-success fs-2">{{$classroom->code}}</span>
           </div>
        </div>
        <div class="col-md-9">
        f
        </div>
    </div>
    @endsection