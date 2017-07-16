<div class="four columns">

	@if($recipe->user)
	<!-- Author Box -->
	<div class="widget">
		<div class="author-box">
			<span class="title">Author</span>
			<span class="name">Gerard</span>
		</div>
	</div>


	<!-- Popular Recipes -->
	<div class="widget">
		<h4 class="headline">Popular Recipes</h4>
		<span class="line margin-bottom-30"></span>
		<div class="clearfix"></div>

		<!-- Recipe #1 -->
		<a href="recipe-page-1.html" class="featured-recipe">
			<img src="assets/images/featuredRecipe-01.jpg" alt="">

			<div class="featured-recipe-content">
				<h4>Choclate Cake With Green Tea Cream</h4>

				<div class="rating five-stars">
					<div class="star-rating"></div>
					<div class="star-bg"></div>
				</div>
			</div>
			<div class="post-icon"></div>
		</a>

		<!-- Recipe #2 -->
		<a href="recipe-page-1.html" class="featured-recipe">
			<img src="assets/images/featuredRecipe-02.jpg" alt="">

			<div class="featured-recipe-content">
				<h4>Mexican Grilled Corn Recipe</h4>

				<div class="rating five-stars">
					<div class="star-rating"></div>
					<div class="star-bg"></div>
				</div>
			</div>
			<div class="post-icon"></div>
		</a>

		<!-- Recipe #3 -->
		<a href="recipe-page-1.html" class="featured-recipe">
			<img src="assets/images/featuredRecipe-03.jpg" alt="">

			<div class="featured-recipe-content">
				<h4>Pollo Borracho With Homemade Tortillas</h4>

				<div class="rating five-stars">
					<div class="star-rating"></div>
					<div class="star-bg"></div>
				</div>
			</div>
			<div class="post-icon"></div>
		</a>

		<div class="clearfix"></div>
	</div>
	@endif

	<!-- Information -->
	<div class="widget">
		<h4 class="headline">Information</h4>
		<span class="line margin-bottom-30"></span>
		<div class="clearfix"></div>

		@if($recipe->source)
			<strong>Source</strong>: {{ HTML::link($recipe->source, parse_url($recipe->source, PHP_URL_HOST) ) }}
			<br>
		@endif

	</div>

	<!-- Nutrition -->
	<div class="widget">
		<h4 class="headline">Nutrition Info (1 portion)</h4>
		<span class="line margin-bottom-30"></span>
		<div class="clearfix"></div>
		@if($recipe->kilojoules !== null)
			<strong>kilo joules</strong>: {{ $recipe->kilojoules }} kj
			<br>
		@endif
		@if($recipe->kilocalories !== null)
			<strong>Kilo calories</strong>: {{ $recipe->kilocalories }} kcal
			<br>
		@endif
		@if($recipe->protein !== null)
			<strong>Proteínas</strong>: {{ $recipe->protein }} g
			<br>
		@endif
		@if($recipe->carbohydrates !== null)
			<strong>Hidratos de carbono</strong>: {{ $recipe->carbohydrates }} g
			<br>
		@endif
		@if($recipe->fat !== null)
			<strong>Grasa</strong>: {{ $recipe->fat }} g
			<br>
		@endif
		@if($recipe->cholesterol !== null)
			<strong>Colesterol</strong>: {{ $recipe->cholesterol }} g
			<br>
		@endif
		@if($recipe->dietaryFibre !== null)
			<strong>Fibra dietética</strong>: {{ $recipe->dietaryFibre }} g
			<br>
		@endif
	</div>

	<!-- Share -->
	<div class="widget">
		<h4 class="headline">Share</h4>
		<span class="line margin-bottom-30"></span>
		<div class="clearfix"></div>

		<ul class="share-buttons">
			<li class="facebook-share">
				<a href="#">
					<span class="counter">1,234</span>
					<span class="counted">Fans</span>
					<span class="action-button">Like</span>
				</a>
			</li>

			<li class="twitter-share">
				<a href="#">
					<span class="counter">863</span>
					<span class="counted">Followers</span>
					<span class="action-button">Follow</span>
				</a>
			</li>

			<li class="google-plus-share">
				<a href="#">
					<span class="counter">902</span>
					<span class="counted">Followers</span>
					<span class="action-button">Follow</span>
				</a>
			</li>
		</ul>
		<div class="clearfix"></div>
	</div>

</div>
