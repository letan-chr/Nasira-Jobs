@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="alert alert-{{ $message['level'] }} {{ $message['important'] ? 'alert-important' : '' }} custom-message bg-{{ $message['level'] }} border border-{{ $message['level'] }}">
            <div class="d-flex text-white align-items-center">
                <i class="fa-solid  fa-face-smile {{ checkLanguageSession() == 'ar' ? 'ms-4' : 'me-4' }}"></i>
                <div>
                    <span class="text-white">{{ $message['message'] }}</span>
                </div>
            </div>
        </div>

    @endif
@endforeach

{{ session()->forget('flash_notification') }}
