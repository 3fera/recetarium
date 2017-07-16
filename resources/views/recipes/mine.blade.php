@extends('layouts.default')

@section('content')

<div class="container">

    <!-- Masonry -->
    <div class="sixteen columns">

        @if($recipes)
        <h3 class="headline">Mis recetas</h3>
        <span class="line rb margin-bottom-35"></span>
        <div class="clearfix"></div>

        <!-- Isotope -->
        <div class="isotope">

            @foreach($recipes as $recipe)
                @include('recipes.partials.mini')
            @endforeach

        </div>
        <div class="clearfix"></div>

        <!-- Pagination -->
        <div class="pagination-container masonry">
            @include('pagination.default', ['paginator' => $recipes])
        </div>

        @else
        <h3 class="headline">Aún no tienes recetas :(</h3>
        <div class="clearfix"></div>
        @endif

    </div>

</div>

@endsection
