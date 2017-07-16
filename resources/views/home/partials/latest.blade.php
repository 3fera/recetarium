<h3 class="headline">Latest Recipes</h3>
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
    {{ $recipes->links('pagination.default') }}
</div>
