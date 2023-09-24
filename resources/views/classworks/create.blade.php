@extends('layouts.master')

@section('title', 'Create Classwork')
@section('content')
    <div class="container">
        <h1>{{ $classroom->name }} (#{{ $classroom->id }})</h1>
        <h3>Create Classwork</h3>
        <hr>
        <form action="{{ route('classrooms.classworks.store', [$classroom->id, 'type' => $type]) }}" method="POST">
            @csrf
            @include('classworks._form')
            {{-- <x-form.floating.control name="title" placeholder="Title">
                <x-form.input name="title" placeholder="Title" />
            </x-form.floating.control>

            <x-form.floating.control name="description" placeholder="Description (Optional)">
                <x-form.textarea name="description" placeholder="Description (Optional)" />
            </x-form.floating.control>
            <div>
                @foreach ($classroom->students as $student)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" value="{{ $student->id }}" name="students[]"
                            id="std-{{ $student->id }}" @checked(!isset($assigned) || in_array($student->id, $assigned))>
                        <label for="std-{{ $student->id }}">{{ $student->name }}</label>
                    </div>
                @endforeach
            </div>
            <x-form.floating.control name="topic_id" placeholder="Topic (Optional)">
                <select class="form-select" name="topic_id" id="topic_id">
                    @foreach ($classroom->topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
                <x-form.error name="topic_id" />
            </x-form.floating.control> --}}
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
    @endsection
