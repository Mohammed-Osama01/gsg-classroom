@extends('layouts.master')
@section('title', 'Classrooms')
@section('content')
    <div class="container">
        <h1> {{ __('Classrooms') }} </h1>
        {{-- <a href="{{ route('classrooms.create') }}" class="btn btn-primary px-3 my-2">Create <i
                class="fa-solid fa-plus"></i></a> --}}
        <x-alert name="success" class="alert-success" />
        <x-alert name="error" id="error" class="alert-danger" />

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($classrooms as $classroom)
            <div class="col w-25">
                <div class="card h-100">
                    <img src="{{ Storage::url($classroom->cover_image_path) }}"
                        class="card-img-top" alt="..." height="85px">
                    <div class="card-body">
                        <a href="{{ route('classrooms.show', $classroom->id) }}"
                            class="d-flex align-items-center justify-content-between">
                            <h5 class="card-title">{{ $classroom->name }}</h5>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <p class="card-text"></p>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0"
                            style="position:absolute;left:90%; top:10px;z-index:10;">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                    aria-expanded="true">
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn dropdown-item" type="submit">Unenroll</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        {!! __('pagination.next') !!}
    </div>
@endsection
@push('scripts')
