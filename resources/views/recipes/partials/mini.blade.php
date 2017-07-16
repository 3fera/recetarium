<div class="four recipe-box columns">

    <!-- Thumbnail -->
    <div class="thumbnail-holder">
        <a href="{{ $recipe->url }}">
            @if($recipe->cover)
                <img src="{{ $recipe->cover->image->url('medium') }}" alt=""/>
            @endif
            <div class="hover-cover"></div>
            <div class="hover-icon">View Recipe</div>
        </a>
    </div>

    <!-- Content -->
    <div class="recipe-box-content">
        <h3><a href="{{ $recipe->url }}">{{ $recipe->name }}</a></h3>

        <div class="rating five-stars">
            <div class="star-rating"></div>
            <div class="star-bg"></div>
        </div>

        <div class="recipe-meta"><i class="fa fa-clock-o"></i> {{ round($recipe->time_total / 60) }} min</div>

        <div class="clearfix"></div>
    </div>
</div>
