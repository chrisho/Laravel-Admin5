<?php
namespace App\Http\Requests;

class AdminRouteRequest extends Request {
    
    public function rules() {        
        return [
            'name' => 'required',
            'route_name' => 'required'
        ];
    }    
}