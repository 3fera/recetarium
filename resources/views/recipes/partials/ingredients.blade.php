<div class="ingredients-container">
    <h3>Ingredientes</h3>
    <ul class="ingredients">
        @foreach($recipe->ingredients as $i => $ingredient)
        <li>
            <input id="check-{{ $i }}" type="checkbox" name="check" value="check-{{ $i }}">
            <label itemprop="ingredients" for="check-{{ $i }}">
                {{ $ingredient->quantity }}
                {{ $ingredient->unit ? str_plural($ingredient->unit->name, $ingredient->quantity) : '' }}
                {{ $ingredient->notation }}
                {{ $ingredient->preparation }}
                {{ $ingredient->otpional ? '(Opcional)' : '' }}
            </label>
        </li>
        @endforeach
    </ul>
    <a href="{{ route('shoppinglist.add', ['slug' => $recipe->slug]) }}" class="button medium color">
        <i class="fa fa-shopping-cart"></i>
        Add to the shopping list
    </a>
</div>
