<?php
namespace App\Http\Controllers\Www;

use Illuminate\Routing\Controller;

class IndexController extends Controller {
    
    public function getIndex() {
        return response("这是主页");
    }
}