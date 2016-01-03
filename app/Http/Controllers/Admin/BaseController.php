<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Model\Common\AdminButtons;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    use AdminButtons;

    public function __construct() {
        debugbar()->disable();
    }
    
    protected function notfound($str = '') {
        return view('admin.common.404', compact('str'));
    }
}
