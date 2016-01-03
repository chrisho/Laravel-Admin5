<?php

namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Admin\BaseController;
use App\Model\Admin\AdminMenu;

use App\Http\Requests\AdminMenuRequest;

class MenuController extends BaseController {

    public function getIndex(AdminMenu $menu) {
        if (request()->has('id')) {
            $id = request('id');
            $menu = $menu->find($id);
            if (!$menu) {
                return redirect('admin/menu');
            }
        }
        $menus = $menu->with(['menus' => function($query) {
                        $query->where('parent_id', '>', 0);
                        $query->orderBy('order_by', 'asc');
                    }])->where('parent_id', 0)->orderBy('order_by', 'asc')->get();
        
        return view('admin.admin.menu.index', compact('menus', 'menu'));
    }

    public function getAdd() {}
    public function postAdd(AdminMenuRequest $request) {

        $menu = new AdminMenu;
        $menu->name = $request->name;
        $menu->parent_id = $request->parent_id;
        $menu->route = trim($request->route);
        $menu->action = trim($request->action);
        $menu->order_by = $request->order_by;

        $menu->save();
        if ($menu->id) {
            \Cache::forget("all_routes");
            return saveok();
        } else {
            return response("操作失败", 422);
        }
    }

    public function getEdit() {}
    public function postEdit(AdminMenuRequest $request) {
        $menu = new AdminMenu;
        if ($request->has('id')) {
            $menu = $menu->find(request('id'));
            if (!$menu) {
                return response('找不到相关记录', 422);
            }
        } else {
            return response('找不到相关记录', 422);
        }

        $menu->name = $request->name;
        $menu->parent_id = $request->parent_id;
        $menu->route = trim($request->route);
        $menu->action = trim($request->action);
        $menu->order_by = $request->order_by;

        if (!$menu->validateParentId()) {
             return response("上级路由不能选择当前修改路由", 422);
        }
        if (!$menu->validateAction()) {
             return response("当前路由为访问地址时，指向控制器不能为空", 422);
        }

        if ($menu->save()) {
            \Cache::forget("all_routes");
            return saveok();
        } else {
            return response('操作失败', 422);
        }
    }

    public function getDelete() {
        $menu = new AdminMenu;
        $menu = $menu->find(request('id', 0));

        $id = $menu->id;
        $menu->delete();

        $menu = $menu->find($id);
        if (empty($menu)) {
            \Cache::forget("all_routes");
            return response('删除成功');
        } else {
            return response('删除失败');
        }
    }

}
