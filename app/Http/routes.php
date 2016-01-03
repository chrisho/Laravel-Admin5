<?php

use Illuminate\Routing\ControllerInspector;
use App\Model\Admin\AdminMenu,
    App\Model\Admin\AdminGeneral,
    App\Model\Admin\AdminRoute;

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

$namespace = env("ADMIN_PREFIX", "Admin");
$lowername = strtolower(env("ADMIN_PREFIX", "admin"));
Route::group(['domain' => $lowername . '.' . env('DOMAIN', ".admin5.cc"),
    'namespace' => $namespace,
    'middleware' => $lowername], function() use ($namespace) {

    Route::group(['namespace' => $namespace], function() {
        Route::get('login', ['as' => 'login', 'uses' => 'UserController@getLogin']);
        Route::post('login', ['as' => 'postlogin', 'uses' => 'UserController@login']);
        Route::get('logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
    });


    Route::group(['middleware' => ['auth']], function() use ($namespace) {
        Route::get("/", ['as' => 'index', 'uses' => 'IndexController@index']);
        Route::get("admin/user/password", ['as' => 'admin/user/password', 'uses' => function() {
                
            }]);

        // 通用路由，不需要设置用户权限角色
        $Generals = AdminGeneral::with('menus')
                        ->where('parent_id', 0)
                        ->orderBy('order_by', 'asc')->get();
        setRoute($Generals, $namespace);

        $_menus = AdminMenu::with(array('menus' => function($query) {
                        return $query->where('parent_id', '>', 0)
                                        ->orderBy('order_by', 'asc');
                    }))->where('parent_id', 0)->orderBy('order_by', 'asc')->get();
        setRoute($_menus, $namespace);
    });
});

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */

$subdomain = explode('.', request()->getHost());
$_subdomain = AdminRoute::whereIn('route_name', $subdomain)
                ->where('parent_id', 0)->first();

if (!$_subdomain) {
    $subdomain = ['www'];
}
$priority_subdomain = AdminRoute::whereIn('route_name', $subdomain)
                ->where('parent_id', 0)->first();

if ($priority_subdomain && $priority_subdomain->priority)
    $subdomain = $priority_subdomain->priority;

$routes = AdminRoute::with(['menus' => function ($query) {
                        return $query->where('action', '!=', '')->get();
                    }])
                ->whereIn('route_name', $subdomain)
                ->where('parent_id', 0)->get();

setRoute($routes, ucfirst($subdomain[0]));

function setRoute($menus, $namespace = 'Admin') {
    
    if ($menus) {
        foreach ($menus as $menu) {
            foreach ($menu->menus as $k => $c) {
                $routable = (new ControllerInspector())->getRoutable(
                        'App\Http\Controllers\\' . $namespace . "\\" .
                        $c->action, $c->route);
                
                if ($namespace != 'Admin') {
                    $c->action = $namespace . "\\" . $c->action;
                }
                foreach ($routable as $k => $v) {
                    if ($v[0]['verb'] == "get") {
                        if (isset($v[1])) {
                            Route::get($v[1]['plain'], ['as' => $v[1]['plain'], 'uses' => $c->action . '@' . $k]);
                            continue;
                        }
                        Route::get($v[0]['plain'], ['as' => $v[0]['plain'], 'uses' => $c->action . '@' . $k]);
                    } elseif ($v[0]['verb'] == "post") {
                        Route::post($v[0]['plain'], ['as' => $v[0]['plain'] . '/post', 'uses' => $c->action . '@' . $k]);
                    }
                }
            }
        }
    }
}
