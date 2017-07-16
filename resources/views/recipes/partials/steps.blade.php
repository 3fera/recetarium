<div class="directions-container">
    <!-- Steps -->
    <h3>Pasos</h3>
    <ol class="directions" itemprop="recipeInstructions">
        @foreach($recipe->steps as $step)
        <li>{{ $step->text }}</li>
        @endforeach
    </ol>

    @if($recipe->info)
    <!-- Info -->
    <h3>Sugerencias</h3>
    <div>
        @foreach(explode('\n', $recipe->info) as $info)
            {{ $info }}<br>
        @endforeach
    </div>
    @endif
</div>
