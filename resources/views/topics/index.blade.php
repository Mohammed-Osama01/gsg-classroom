@extends('layouts.master')

@section('title', 'Topics')
@section('content')
<div class="container">

    <h1>Topics</h1>
    <a href="{{ route('topics.create', 19) }}" class="btn btn-primary px-3 my-2">Create <i class="fa-solid fa-plus"></i></a>
    <a href="{{ route('topics.trashed', 19) }}" class="btn btn-primary px-3 my-2">Trashed <i class="fa-solid fa-trash"></i></a>
    <div class="col my-5">

        @foreach ($topics as $topic)
            <div class=" mb-5 border-bottom py-2 d-flex justify-content-between">
                <h5 class="">{{ $topic->name }}</h5>
                <div>

                    <a href="{{ route('topics.show', [$topic->id, 19]) }}" class="d-inline btn btn-secondary" type="button">Show</a>
                    <a href="{{ route('topics.edit', [$topic->id, 19]) }}" class="d-inline btn btn-secondary" type="button">Edit</a>

                        <form action="{{ route('topics.destroy', [$topic->id, 19]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="d-inline btn btn-secondary">Delete</button>
                        </form>
                </div>

            </div>
        @endforeach
    </div>

</div>
@endsection
