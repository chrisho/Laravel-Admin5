<?php
namespace App\Http\Requests;

class AdminRoleRequest extends Request {
    
    public function rules() {        
        return [
            'name' => 'required|min:3',
            'display_name' => 'required'
        ];
    }    
}