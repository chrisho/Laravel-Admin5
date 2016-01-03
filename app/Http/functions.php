<?php

use App\Model\Common\CommonSetting;

if (!function_exists("setting")) {
    function setting( $name ) {
        return CommonSetting::aim($name);
    }
}

if (!function_exists("saveok")) {
    function saveok($url = "", $text = "操作成功，请稍候...") {
        return json_encode(['text' => $text, 'url' => $url]);
    }
}

if (!function_exists("adminbuttons")) {
    class _AdminButtons {
        use \App\Model\Common\AdminButtons;        
    }
    function adminbuttons($id, $route, $t = 0, $other = "") {
        $ab = new _AdminButtons();
        if ($t == 1) {        
            return $ab->ab_b($id, $route, $other);
        } elseif ($t == 2) {            
            return $ab->ab_tb($id, $route, $other);
        }else {
            return $ab->ab_t($id, $route, $other);
        }
    }
}
