<li class="nav-item dropdown" style="border-radius: 25px">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        Notifications {{ $unreadCount }}
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

            @if ($notifications->isEmpty())
                <li><p class="dropdown-item text-muted">{{ __('NO notification') }}</p></li>
            @else
                @foreach ($notifications as $notification)
                    <li>
                        <a class="dropdown-item" href="{{ $notification->data['link'] }}?nid={{ $notification->id }}">
                            {{ $notification->data['body'] }}
                            <br>
                            <small class="text-muted">
                                {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                @endforeach
            @endif
        </ul>

</li>
