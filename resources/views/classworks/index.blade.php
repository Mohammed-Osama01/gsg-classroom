<x-main-layout :title="$classroom->name">
    <div class="container">
        <h1>{{ $classroom->name }} - (#{{ $classroom->id }})</h1>
        <h3>Classwork
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    + Create
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item"
                            href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'assignment']) }}">Assignment</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'material']) }}">Material</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'question']) }}">Question</a>
                    </li>
                </ul>
            </div>
        </h3>
        <hr>

        @forelse ($classworks as $group)
            <h3>{{ $group->first()->topic?->name }}</h3>
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($group as $classwork)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse{{ $classwork->id }}" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                {{ $classwork->title }}
                            </button>
                        </h2>
                        <div id="flush-collapse{{ $classwork->id }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                {{ $classwork->description }}
                                <div>
                                    <a class="btn btn-sm btn-outline-dark" href="{{route('classrooms.classworks.edit',[$classwork->classroom_id, $classwork->id])}}">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-center fs-4">No classworks found.</p>
        @endforelse
    </div>
</x-main-layout>
