<?php 
namespace App\Model\Admin;

use App\Model\BaseEloquent;

use App\Model\Admin\AdminMenu;

class AdminRole extends BaseEloquent
{
    public function validateRoles(array $roles) {
        $user = auth()->user();
        $roleValidation = new stdClass();
        foreach ($roles as $role) {
            $roleValidation->$role = ( empty($user) ? false : $user->hasRole($role) );
        }
        return $roleValidation;
    }

    public function menus() {
        return $this->belongsToMany('App\Model\Admin\AdminMenu', 'admin_menu_roles', 'role_id', 'menu_id');
    }

    public function sync($menu_id) {
        foreach ($menu_id as $k => $v) {
            $m = AdminMenu::find($v);
            if (!in_array($m->parent_id, $menu_id)) {
                $menu_id[] = $m->parent_id;
            }
        }
        $this->menus()->sync($menu_id);
    }
}