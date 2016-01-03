<?php
namespace App\Http\Controllers\Admin\Admin;

use App\Http\Controllers\Admin\BaseController;

use App\Model\Admin\AdminRole;
use App\Model\Admin\AdminMenu;
use App\Http\Requests\AdminRoleRequest;

class RoleController extends BaseController {
    
    public $role, $menu;
    
    public function __construct() {
        parent::__construct();
        
        $this->role = new AdminRole;
        $this->menu = new AdminMenu;
    }
    
    public function getIndex() {
        return view('admin.admin.role.index');
    }

    public function getData() {
        
        $roles = $this->role->select(['id', 'name', 'display_name'])
                ->orderBy('id', 'desc');
        
        return \Datatables::of($roles)
                ->addColumn('operation', function($row){
                    return adminbuttons($row->id, 'admin/role', 2);
                })->removeColumn('id')->make();
    }
    
    public function getAdd() {
        $menus = $this->menu->with(array('menus' => function($query) {
                $query->orderBy('order_by', 'asc');
            }))->where('parent_id', 0)->orderBy('order_by', 'asc')->get();

        return view('admin/admin/role/add', compact('menus'));
    }

    public function postAdd(AdminRoleRequest $request) {
        $this->role->name = $request->get('name');
        $this->role->display_name = $request->get('display_name');

        $this->role->save();

        if ($this->role->id) {
            $menu_id = $request->get('menu_id');
            if (!empty($menu_id)) {  
                $this->role->sync($menu_id);
            }

            return saveok();
        } else {
            return response('操作失败', 422);
        }
    }

    public function getEdit() {
        $role = $this->role->find(request('id'));
        if (!$role) {
            return $this->notfound();
        }

        $menus = $this->menu->with(array('menus' => function($query) {
                $query->orderBy('order_by', 'asc');
            }))->where('parent_id', 0)->orderBy('order_by', 'asc')->get();
            
        $menu_role = $role->menus()->get()->toArray();
                
        $menu_role = array_pluck($menu_role, 'id');
        
        return view('admin.admin.role.edit', compact('menus','role','menu_role'));
    }

    public function postEdit(AdminRoleRequest $request) {
        $this->role = $this->role->find($request->get('id'));
        if (!$this->role->id) {
            return response('找不到相关记录', 422);
        }
        
        $this->role->name = $request->get('name');
        $this->role->display_name = $request->get('display_name');

        $this->role->save();

        if ($this->role->id) {
            
            $menu_id = $request->get('menu_id');
            if (!empty($menu_id)) {                
                $this->role->sync($menu_id);
            }

            return saveok();
        } else {
            return response('操作失败', 422);
        }
    }

    public function getDelete() {
        $this->role = $this->role->find(request('id', 0));
        
        $id = $this->role->id;
        $this->role->menus()->detach();
        $this->role->delete();

        $role = $this->role->find($id);
        if (empty($role)) {
            return response('删除成功');
        } else {
            return response('删除失败', 422);
        }
    }
}