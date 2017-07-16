<!-- Headline -->
@if(count($related))
<h3 class="headline">You may also like</h3>
<span class="line margin-bottom-35"></span>
<div class="clearfix"></div>

<div class="related-posts">
@foreach($related as $recipe)
    @include('recipes.partials.mini')
@endforeach
</div>
<div class="clearfix"></div>
@endif
