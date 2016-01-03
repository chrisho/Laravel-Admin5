<?php
namespace App\Model\Admin;

use App\Model\BaseEloquent;

class AdminGeneral extends BaseEloquent{
    public function children() {
        return $this->hasMany('AdminGeneral', 'parent_id', 'id');
    }    
    public function menus() {
        return $this->hasMany('AdminGeneral', 'parent_id', 'id');
    }  
}
