<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Model\Admin\AdminRoute;
use App\Http\Requests\AdminRouteRequest;

class RoutesController extends BaseController {

    public $routes;

    public function __construct() {
        parent::__construct();
        $this->routes = new AdminRoute();

        $routes = $this->routes->where('parent_id', 0)
                        ->with(['menus' => function($query) {
                                return $query->where('action', '!=', '');
                            }])->get();

        \View::share('routes', $routes);
    }

    public function getIndex() {
        $route = $this->routes->find(request('id'));
        if (empty($route))
            $route = $this->routes;

        return view('admin.admin.route.index', compact('route'));
    }

    public function getAdd() {
        
    }

    public function postAdd(AdminRouteRequest $request) {
        $parent_id = $request->get('parent_id');
        $action = $request->get('action');
        $route_name = $request->get('route_name');

        if ($parent_id != 0) {
            if (empty($action) && !\Event::hasListeners('router.filter: ' . $route_name))
                return response($route_name . '：路由验证不存在', 422);
            if (!empty($action) && !class_exists('App\Http\Controllers\\'. $action))
                return response($action . '：控制器不存在', 422);
        } else {
            $route_name = strtolower($route_name);
        }

        $this->routes->name = $request->get('name');
        $this->routes->action = $action;
        $this->routes->route_name = $route_name;
        $this->routes->other_route = $request->get('other_route', '');
        $this->routes->parent_id = $parent_id;

        if ($this->routes->save()) {
            \Cache::forget($route->route_name . "_routes");
            return saveok();
        } else {
            return response('操作失败');
        }
    }

    public function getEdit() {
        
    }

    public function postEdit(AdminRouteRequest $request) {
        $parent_id = $request->get('parent_id');
        $action = $request->get('action');
        $route_name = $request->get('route_name');
        $route = $this->routes->find($request->get('id'));

        if (!$route)
            return response('找不到相关记录', 422);

        if ($parent_id != 0) {
            if (empty($action) && !\Event::hasListeners('router.filter: ' . $route_name))
                return response($route_name . '：路由验证不存在', 422);
            if (!empty($action) && !class_exists('App\Http\Controllers\\' . $action))
                return response($action . '：控制器不存在', 422);
        } else {
            $route_name = strtolower($route_name);
        }

        $route->name = $request->get('name');
        $route->action = $action;
        $route->route_name = $route_name;
        $route->other_route = $request->get('other_route', '');
        $route->parent_id = $parent_id;
        $route->priority = $request->has('priority') ? $request->get('priority') : '';
        if ($route->save()) {
            \Cache::forget($route->route_name . "_routes");
            return saveok();
        } else {
            return response('保存失败', 422);
        }
    }

    public function getDelete() {
        $id = request('id');
        $route = $this->routes->find($id);
        $route_name = $route->route_name;

        if (!$route)
            return redirect(route('admin/route'));
        if ($this->routes->where('parent_id', $id)->first())
            return response('该目录有下一级，不能删除', 422);

        $route->delete();

        if (!$this->routes->find($id)) {
            \Cache::forget($route_name . "_routes");
            return response('删除成功');
        } else {
            return response('删除失败', 422);
        }
    }

}
