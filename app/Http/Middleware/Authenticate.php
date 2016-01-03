<?php

namespace App\Http\Middleware;

use Closure,
    Route;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\AdminMenu,
    App\Model\Admin\AdminMenuRole,
    App\Model\Admin\AdminAssignedRole;
    

class Authenticate {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }
        if (auth()->user()->confirmed == 0) {
            Auth::logout();
            return redirect()->guest('login');
        }
        $menus_id = AdminMenuRole::whereIn('role_id', function($query){            
            return $query->from(AdminAssignedRole::query()->getModel()->getTable())
                    ->select("role_id")
                    ->where('user_id', auth()->user()->id);
        })->lists('menu_id');

        $_menus = AdminMenu::with(array('menus' => function($query) use ($menus_id) {
                            $query->whereIn('id', $menus_id);
                                    $query->where('parent_id', '>', 0);
                                    $query->orderBy('order_by', 'asc');
                                }))->where('parent_id', 0)->orderBy('order_by', 'asc')->get();
        view()->share('_menus', $_menus);
        
        $menus = [];
        $_menus = $_menus->pluck("menus")->toArray();
        foreach ($_menus as $v) {
           $menus = array_merge($menus, $v);
        }
        
        $routes = array_pluck($menus, 'route');
        $routes = str_replace(["/"], ["\/"], $routes);
        array_walk($routes,function(&$v, $k){
            $v = "^$v*";
        });   
        $all_routes = \Cache::get("all_routes", function() {
            $all_routes = AdminMenu::where('parent_id', '>', 0)->lists("route")->toArray();
            $all_routes = str_replace(["/"], ["\/"], $all_routes);
            array_walk($all_routes,function(&$v, $k){
                $v = "^$v*";
            });  
            \Cache::forever("all_routes", $all_routes);
            return $all_routes;
        });
        $currentRoute = Route::currentRouteName();
        if (!preg_match('/'.implode("|", $routes).'/', $currentRoute)
            && preg_match('/'.implode("|", $all_routes).'/', $currentRoute)
                ) {
            return redirect()->to("/");
        }
        
        return $next($request);
    }
    
    

}
