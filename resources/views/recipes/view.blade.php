@extends('layouts.default')

@section('title') {{ $recipe->name }} @stop

@section('content')

<!-- Recipe Background -->
<div class="recipeBackground">
	@if($recipe->cover)
	<img src="{{ $recipe->cover->image->url('large') }}" alt="" />
	@endif
</div>

<!-- Content
================================================== -->
<div class="container" itemscope itemtype="http://schema.org/Recipe">

	<!-- Recipe -->
	<div class="twelve columns">
	<div class="alignment">

		<!-- Header -->
		<section class="recipe-header">
			<div class="title-alignment">
				<h2>{{ $recipe->name }}</h2>
				<div class="rating four-stars">
					<div class="star-rating"></div>
					<div class="star-bg"></div>
				</div>
				<span><a href="#reviews">(2 reviews)</a></span>
			</div>
		</section>

		<!-- Slider -->
		<div class="recipeSlider rsDefault">
		    @foreach($recipe->images as $image)
				<img itemprop="image" class="rsImg" src="{{ $image->image->url('large') }}" alt="" />
			@endforeach
		</div>

		<!-- Details -->
		<section class="recipe-details" itemprop="nutrition">
			<ul>
				<li>Tiempo Activo <strong itemprop="prepTime">{{ round($recipe->time_active / 60) }} min</strong></li>
				<li>Tiempo Total <strong itemprop="prepTime">{{ round($recipe->time_total / 60) }} min</strong></li>
				<li>Raciones <strong itemprop="recipeYield">{{ $recipe->portions }} personas</strong></li>
				@if($recipe->difficulty_level)
					<li>Dificultad <strong itemprop="difficulty">
						{{ HTML::difficultyLevel($recipe->difficulty_level) }}
					</strong></li>
				@endif
				@if($recipe->price_level)
					<li>Precio <strong itemprop="price">{{ HTML::priceLevel($recipe->price_level) }}</strong></li>
				@endif
				@if($recipe->kilocalories)
					<li>Calorías <strong itemprop="calories">{{ $recipe->kilocalories }} kcal</strong></li>
				@endif
			</ul>
			<a href="#" class="print"><i class="fa fa-print"></i> Imprimir</a>
			<div class="clearfix"></div>
		</section>

		<!-- Text -->
		<p itemprop="description">
			{{ $recipe->description }}
		</p>

		<div class="recipe-container">
			@include('recipes.partials.ingredients')
			@include('recipes.partials.steps')
		</div>
		<div class="clearfix"></div>

		@include('recipes.partials.share')

		<div class="margin-bottom-40"></div>

		@include('recipes.partials.related')

		<div class="margin-top-15"></div>

		@include('recipes.partials.comments')

	</div>
</div>


@include('recipes.partials.sidebar')

@endsection
