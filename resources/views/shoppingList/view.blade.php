@extends('layouts.default')

@section('title') Lista de compra @stop

@section('content')

<!-- Titlebar
================================================== -->
<section id="titlebar">
	<!-- Container -->
	<div class="container">
		<div class="eight columns">
			<h2>Lista de compra</h2>
		</div>
	</div>
	<!-- Container / End -->
</section>

<div class="margin-top-35"></div>

<!-- Content
================================================== -->
<div class="container">

	<!-- Recipe -->
	<div class="twelve columns">
    	<div class="alignment">

			<br><br>

			<!-- Recipes -->
			@if(count($recipes))
				<h3>Recetas</h3>
				@foreach($recipes as $recipe)
	    			{{ $recipe->name }}
					<a href="{{ route('shoppinglist.remove', ['slug' => $recipe->slug]) }}" class="button medium color">
						<i class="fa fa-remove"></i>
						Remove
					</a>
					<br>
				@endforeach
			@endif

    		<!-- Ingredients -->
			@if(count($shoppingCategories))
				<h3>Ingredientes</h3>
	            @foreach($shoppingCategories as $shoppingCategory)
	                <ul class="ingredients shopping-list">
	                    <li>
	                        <h5>{{ $shoppingCategory['category']->name }}</h5>
	                    </li>
	                    @foreach($shoppingCategory['ingredients'] as $i => $ingredient)
	    				<li>
	                        <input id="check-{{ $i }}" type="checkbox" name="check" value="check-{{ $i }}">
	        				<label itemprop="ingredients" for="check-{{ $i }}">
	                            {{ $ingredient['total'] }}
	                            {{ $ingredient['ingredient']->unit ? str_plural($ingredient['ingredient']->unit->name, $ingredient['total']) : '' }}
	                            {{ $ingredient['ingredient']->notation }}
	                        </label>
	                    </li>
	                @endforeach
	                </ul>
	            @endforeach
			@else
				<blockquote>
					No has añadido ninguna receta a tu lista de compra :(
				</blockquote>
			@endif
        </div>
    </div>

</div>
@endsection
