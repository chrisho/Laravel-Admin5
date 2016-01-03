<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController;

class IndexController extends BaseController {
    
    public function index() {
        return view('admin.index');
    }
}

