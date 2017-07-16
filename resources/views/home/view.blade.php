@extends('layouts.default')

@section('title') Inicio @stop

@section('content')

<!-- Slider -->
@include('home.partials.slider')

<div class="container">

	<!-- Masonry -->
	<div class="twelve columns">
        @include('home.partials.latest')
    </div>

	<!-- Sidebar
	================================================== -->
    @include('home.partials.sidebar')

</div>
@endsection
