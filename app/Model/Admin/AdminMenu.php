<?php 
namespace App\Model\Admin;

use App\Model\BaseEloquent;

class AdminMenu extends BaseEloquent
{            
    public function menus() {
        return $this->hasMany('App\Model\Admin\AdminMenu','parent_id');
    }
    
    public function roles() {
        return $this->belongsToMany('App\Model\Admin\AdminRole', 'menu_role');
    }
    
    public function validateAction() {
        if ($this->parent_id > 0 && empty($this->action)) 
            return false;
        return true;
    }
    
    public function validateParentId() {
        if ($this->parent_id == $this->id) 
            return false;
        $menu = $this->find($this->parent_id);
        if ($menu) {
            if ($menu->parent_id > 0) 
                return false;            
        }
        return true;
    }
}