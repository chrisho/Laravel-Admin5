<?php
namespace App\Http\Requests;

class AdminMenuRequest extends Request {
    
    public function rules() {        
        return [
            'name' => 'required',
            'route' => 'required',
            'order_by' => 'numeric'
        ];
    }    
}