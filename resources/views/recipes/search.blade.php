@extends('layouts.default')

@section('title') Recetas @stop

@section('content')

<!-- Titlebar
================================================== -->
<section id="titlebar" class="browse-all">
	<!-- Container -->
	<div class="container">

		<div class="eight columns">
			<h2>Buscar recetas</h2>
		</div>

	</div>
	<!-- Container / End -->
</section>

{!! Form::open(['route' => 'recipes.list']) !!}

<!-- Container -->
<div class="advanced-search-container">
	<div class="container">
		<div class="sixteen columns">
			<div id="advanced-search">

				<!-- Choose Category -->
				<div class="select">
					<label>Categoría</label>
                    {!! Form::select('category', [null => 'Todas'] + $categories, Request::get('category'), ['data-placeholder' => 'Selecciona una categoría', 'class' => 'chosen-select-no-single']) !!}
				</div>

				<!-- Choose Ingredients -->
				<div class="select included-ingredients">
					<label>Selecciona uno o más ingredientes</label>
					{!! Form::select('with-ingredients[]', $ingredients, Request::get('with-ingredients'), ['data-placeholder' => 'Ingredientes incluidos', 'class' => 'chosen-select', 'multiple']) !!}
				</div>

				<!-- Choose -->
				<div class="select">
					<label>La receta debe tener</label>
                    {!! Form::select('with-ingredients-rule', [
                        1 => 'Todos los ingredientes seleccionados',
                        2 => 'Alguno de los ingredientes seleccionados',
                    ], Request::get('with-ingredients-rule'), ['data-placeholder' => 'Selecciona una opción', 'class' => 'chosen-select']) !!}
				</div>

				<div class="clearfix"></div>

				<!-- Search Input -->
				<nav class="search-by-keyword">
					<button><span>Buscar recetas</span><i class="fa fa-search"></i></button>
					<input class="search-field" type="text" placeholder="Buscar por texto" name="search" value="{{ Request::get('search') }}"/>
				</nav>
				<div class="clearfix"></div>


				<!-- Advanced Search Button -->
				<a href="#" class="adv-search-btn">Búsqueda avanzada<i class="fa fa-caret-down"></i></a>


				<!-- Extra Search Options -->
				<div class="extra-search-options @if(Request::get('without-ingredients') || Request::get('portions') > 0 || Request::get('time') > 0 || Request::get('kcal') > 0) {{ 'opened' }} @else {{ 'closed' }} @endif">


					<!-- Choose Excluded Ingredients -->
					<div class="select excluded-ingredients">
						<label>Selecciona uno o más ingredientes que NO deberán tener la receta</label>
						{!! Form::select('without-ingredients[]', $ingredients, Request::get('without-ingredients'), ['data-placeholder' => 'Ingredientes excluidos', 'class' => 'chosen-select', 'multiple']) !!}
					</div>

					<div class="clearfix"></div>

					<!-- Choose serving -->
					<div class="select">
						<label>Selecciona las raciones</label>
                        {!! Form::select('portions', [
                            0 => 'Cualquiera',
                            '1' => 'Para 1 persona',
                            '2' => 'Para 2 personas',
                            '4' => 'Para 4 personas',
                            '6' => 'Para 6 personas',
							'8' => 'Para 8 o más',
                        ], Request::get('portions'), ['data-placeholder' => 'Selecciona las raciones', 'class' => 'chosen-select']) !!}
					</div>

					<!-- Choose time needed -->
					<div class="select">
						<label>Selecciona el tiempo necesario</label>
                        {!! Form::select('time', [
                            0 => 'Cualquiera',
                            '1800' => 'Menos de media hora',
                            '3799' => 'Menos de una hora',
                            '3600' => 'Más de una hora',
                        ], Request::get('time'), ['data-placeholder' => 'Selecciona el tiempo necesario', 'class' => 'chosen-select']) !!}
					</div>

					<!-- Kcal -->
					<div class="select">
						<label>Selecciona el valor energético</label>
                        {!! Form::select('kcal', [
                            0 => 'Cualquiera',
                            '200' => 'Menos de 200 kcal',
                            '399' => 'Menos de 400 kcal',
                            '400' => 'Más de 400 kcal',
                        ], Request::get('kcal'), ['data-placeholder' => 'Selecciona el valor energéticoo', 'class' => 'chosen-select']) !!}
					</div>

					<div class="clearfix"></div>
					<div class="margin-top-10"></div>

				</div>
				<!-- Extra Search Options / End -->

			<div class="clearfix"></div>
			</div>

		</div>
	</div>
</div>


<div class="margin-top-35"></div>

<div class="container">

    <!-- Masonry -->
    <div class="sixteen columns">

        @if($recipes)
        <h3 class="headline">Recetas encontradas</h3>
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
			{{ $recipes->links('pagination.form') }}
        </div>

        @else
        <h3 class="headline">No se han encontrado recetas :(</h3>
        <div class="clearfix"></div>
        @endif

    </div>

</div>

{!! Form::close() !!}

@endsection
