<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Lavary\Menu\Facade as Menu;

class MenuBuilder
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        Menu::make('mainMenu', function ($menu) use ($guard) {
            $menu->add('Inicio');
            $menu->add('Recetas', ['route' => 'recipes.list']);
            $menu->add('Lista de compra', ['route' => 'shoppinglist.show']);
            if (Auth::guard($guard)->guest()) {
                $menu->add('Acceder', 'login');
                $menu->add('Registro', 'register');
            }else{
                $menu->add('Mi cuenta', ['route' => 'account', 'nickname' => 'account']);
                $menu->account->add('Mis recetas', ['route' => 'recipes.mine']);
                $menu->account->add('Subir receta', ['route' => 'recipes.create']);
                $menu->account->add('Cuenta', ['route' => 'account']);
                $menu->account->add('Salir', 'logout');
            }
        });

        return $next($request);
    }
}
