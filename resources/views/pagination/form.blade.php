{{ Form::hidden('page', Request::get('page'), ['id' => 'pagination-page']) }}

@if ($paginator->hasPages())
<nav class="pagination">
    <ul>
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled">
                    <span class="page-link">{{ $element }}</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="{{ ($paginator->currentPage() == $page) ? 'current-page' : ''}}">
                                {{ $page }}
                            </a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="{{ $page }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach
    </ul>
</nav>

<nav class="pagination-next-prev">
    <ul>
        <li><a href="#" data-page="{{ $paginator->url(1) }}" class="prev"></a></li>
        <li><a href="#" data-page="{{ $paginator->url($paginator->currentPage()+1) }}" class="next"></a></a></li>
    </ul>
</nav>

@section('scripts')
<script>
    $('.pagination a, .pagination-next-prev a').click(function(event) {
        event.preventDefault();
        val = $(this).data('page');
        $('#pagination-page').val(val);
        $(this).parents('form:first').submit();
    });
    $('form').click(function(event) {
        if($(this).find('#pagination-page').length) {
            $('#pagination-page').val(1);
        }
    });
</script>
@stop
@endif
