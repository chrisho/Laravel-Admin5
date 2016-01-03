<?php

namespace App\Http\Requests;

class AdminUserRequest extends Request {

    public function rules() {
        return [
            'telephone' => 'required|digits:11',
            'truename' => 'required'
        ];
    }

}
