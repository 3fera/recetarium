@foreach ((array) session('flash_notification') as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="notification {{ $message['level'] }} closeable">
			<p>{!! $message['message'] !!}</p>
			<a class="close" href="#"></a>
		</div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
