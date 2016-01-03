<?php
namespace App\Model\Common;

use App\Model\BaseEloquent;

class CommonSetting extends BaseEloquent {

    static function aim($name, $cache = true) {

        if (\Cache::has('setting') && $cache) {
            $setting = \Cache::get('setting');
        } else {
            $_setting = self::get();
           
            $setting = array();
            foreach ($_setting as $v) {
                $setting[$v->name] = $v->value;
            }

            \Cache::put('setting', $setting, 1);
        }

        if ($setting && isset($setting[$name])) {
            return $setting[$name];
        } else {
            return false;
        }
    }
}
