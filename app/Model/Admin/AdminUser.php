<?php

namespace App\Model\Admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Authenticatable
{        
    use SoftDeletes;
    
    public $timestamps = true; // 控制自动时间戳; 默认为false
    
    protected function getDateFormat() {
        return 'U';
    } 
    
    public function roles() {        
        return $this->belongsToMany("App\Model\Admin\AdminRole", AdminAssignedRole::query()->getModel()->getTable(), 'user_id', 'role_id');
    }
    /**
     * Save roles inputted from multiselect
     * @param $inputRoles
     */
    public function saveRoles($inputRoles) {

        if (!empty($inputRoles)) {
            $this->roles()->sync($inputRoles);
        } else {
            $this->roles()->detach();
        }
    }
    
    public function currentRoleIds() {
        $roles = $this->roles;
        $roleIds = false;
        if (!empty($roles)) {
            $roleIds = array();
            foreach ($roles as &$role) {
                $roleIds[] = $role->id;
            }
        }
        return $roleIds;
    }

        
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'token',
    ];
}
