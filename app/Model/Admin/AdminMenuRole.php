<?php
namespace App\Model\Admin;

use App\Model\BaseEloquent;

class AdminMenuRole extends BaseEloquent
{
    public function menusid($roles_id) {
        if (!is_array($roles_id)) {
            $roles_id = array($roles_id);
        }        
        return $this->whereIn('role_id', $roles_id)->get();
    }
}
