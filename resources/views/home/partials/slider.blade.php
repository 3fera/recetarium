<!-- Slider
================================================== -->

<div id="homeSlider" class="royalSlider rsDefaultInv">

	@foreach($sliderRecipes as $recipe)

	<div class="rsContent">
		<a class="rsImg" href="{{ $recipe->cover->image->url('large') }}"></a>
		<i class="rsTmb">{{ $recipe->name }}</i>

		<!-- Slide Caption -->
		<div class="SlideTitleContainer rsABlock">
		<div class="CaptionAlignment">
			<div class="rsSlideTitle tags">
				<ul>
					<li>Baking</li>
				</ul>
				<div class="clearfix"></div>
			</div>

			<h2 class="rsSlideTitle title"><a href="{{ $recipe->url }}">{{ $recipe->name }}</a></h2>

			<div class="rsSlideTitle details">
				<ul>
					<li><i class="fa fa-cutlery"></i> 4 Servings</li>
					<li><i class="fa fa-clock-o"></i> 30 Min</li>
					<li><i class="fa fa-user"></i> by <a href="#">Sandra Fortin</a></li>
				</ul>
			</div>

			<a href="{{ $recipe->url }}" class="rsSlideTitle button">Ver receta</a>
		</div>
		</div>

	</div>

	@endforeach

</div>
