@extends('layouts.default')

@section('content')

<section id="titlebar">
	<!-- Container -->
	<div class="container">

		<div class="eight columns">
			<h2>Subir receta</h2>
		</div>

	</div>
	<!-- Container / End -->
</section>

<div class="container">
	<div class="sixteen columns">
		<div class="submit-recipe-form">

            {!! Form::open(['route' => 'recipes.store']) !!}

			<!-- Recipe Title -->
			<h4>Título</h4>
			<nav class="title @if ($errors->has('title')) has-error @endif">
				{!! Form::text('title', old('title'), ['placeholder' => 'Título de la receta', 'required']) !!}
				@if ($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
			</nav>
			<div class="clearfix"></div>

			<div class="margin-top-25"></div>

			<!-- Choose Category -->
			<h4>Categoría</h4>
			<nav class="@if ($errors->has('category_id')) has-error @endif">
				{!! Form::select('category_id', $categories, old('category_id'), ['data-placeholder' => 'Selecciona una categoría', 'class' => 'chosen-select-no-single', 'required']) !!}
				@if ($errors->has('category_id')) <p class="help-block">{{ $errors->first('category_id') }}</p> @endif
			</nav>

			<div class="margin-top-25"></div>

			<!-- Short Summary -->
			<h4>Descripción</h4>
			{!! Form::textarea('description', old('description'), ['placeholder' => 'Pequeña introducción']) !!}

			<div class="margin-top-25"></div>

			<!-- Ingredients -->
			<fieldset class="addrecipe-cont" name="ingredients">
				<h4>Ingredients:</h4>

				<table id="ingredients-sort">

					<tr class="ingredients-cont ing">
						<td class="icon"><i class="fa fa-arrows"></i></td>
						<td width="20">
							<input name="ingredient_name" type="text" placeholder="2" />
						</td>
						<td>
							{!! Form::select('ingredient_unit[]', $units, null, ['data-placeholder' => 'Gramos', 'class' => 'chosen-select']) !!}
						</td>
						<td>
							{!! Form::select('ingredient_name[]', $ingredients, null, ['data-placeholder' => 'Pimientos verdes', 'class' => 'chosen-select']) !!}
						</td>
						<td><input name="ingredient_note" type="text" placeholder="cortados a tiras" /></td>
						<td class="action"><a title="Delete" class="delete" href="#"><i class="fa fa-remove"></i></a> </td>
					</tr>

				</table>

				<a href="#" class="button color add_ingredient">Add new ingredient</a>
				<a href="#" class="button add_separator">Add separator</a>
			</fieldset>

			<div class="margin-top-25"></div>

			<!-- Directions -->
			<h4>Indicaciones</h4>
			<nav class="@if ($errors->has('preparation')) has-error @endif">
				{!! Form::textarea('preparation', old('preparation'), ['placeholder' => 'Escribe cada paso en una línea nueva', 'required']) !!}
				@if ($errors->has('preparation')) <p class="help-block">{{ $errors->first('preparation') }}</p> @endif
			</nav>

			<div class="margin-top-25 clearfix"></div>

			<!-- Upload Photos -->
			<h4>Imágenes</h4>

			<ul class="recipe-gallery">
				<li>Aún no hay imágenes</li>
			</ul>

			<label class="upload-btn">
			    <input type="file" multiple="">
			    <i class="fa fa-upload"></i> Subir
			</label>

			<div class="clearfxix"></div>
			<div class="margin-top-15"></div>

			<!-- Advice -->
			<h4>Consejo</h4>
			{!! Form::textarea('advice', old('advice'), ['placeholder' => '¿Algún consejo?']) !!}

			<div class="margin-top-25 clearfix"></div>

			<!-- Additional Informations -->
			<h4>Información adicional</h4>

			<fieldset class="additional-info">
				<table>

				<tr class="ingredients-cont">
					<td class="label"><label for="5">Porciones</label></td>
					<td>
						{!! Form::text('portions', old('portions'), ['placeholder' => '¿Para cuantas personas es?']) !!}
					</td>
				</tr>
				<tr class="ingredients-cont">
					<td class="label"><label for="5">Tiempo activo</label></td>
					<td>
						{!! Form::text('portions', old('portions'), ['placeholder' => '¿Cuanto tiempo de preparación?']) !!}
					</td>
				</tr>
				<tr class="ingredients-cont">
					<td class="label"><label for="5">Tiempo de espera</label></td>
					<td>
						{!! Form::text('waiting_time', old('waiting_time'), ['placeholder' => '¿Cuanto tiempo de espera?']) !!}
					</td>
				</tr>
				<tr class="ingredients-cont">
					<td class="label"><label for="5">Fuente</label></td>
					<td>
						{!! Form::text('source', old('source'), ['placeholder' => 'Si la receta no es tuya, indicanos donde la has encontrado']) !!}
					</td>
				</tr>
				<tr class="ingredients-cont">
					<td class="label"><label for="5">Kilo Calorías</label></td>
					<td>
						{!! Form::text('kcal', old('kcal'), ['placeholder' => 'Kcal']) !!}
					</td>
				</tr>

				</tbody></table>
			</fieldset>


			<div class="margin-top-25"></div>

			<div class="margin-top-30"></div>
			<input type="submit" class="btn" value="Enviar receta">

			{{ Form::close() }}

		</div>
	</div>
</div>

@endsection
