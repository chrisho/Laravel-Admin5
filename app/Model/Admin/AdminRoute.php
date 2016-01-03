<?php
namespace App\Model\Admin;

use App\Model\BaseEloquent;

class AdminRoute extends BaseEloquent{
    
    public static function getChild($parent_id = 0){
        return self::where('parent_id',$parent_id)->get();
    }
    
    public function menus() {
        return $this->hasMany('App\Model\Admin\AdminRoute', 'parent_id', 'id');
    }    
    
    public static function setRoutes($routes) {
        foreach ($routes as $c) {
            if (class_exists($c->action)) {
                 if ($c->route_name == '/') {
                    $routable = \Route::getInspector()
                         ->getRoutable($c->action,'');
                 } else {
                     $routable = \Route::getInspector()
                         ->getRoutable($c->action, $c->route_name);
                 }

                foreach ($routable as $k=>$v) {
                      if ($v[0]['verb'] == 'get') {
                         if (isset($v[1])) {
                             if ($v[1]['plain'] == '') {
                                 \Route::get('/', ['as'=>'/','uses'=>$c->action.'@'.$k]);
                             } else {
                                 \ Route::get($v[1]['plain'], ['as'=>$v[1]['plain'],'uses'=>$c->action.'@'.$k]);
                             }
                            continue;    
                         }
                         \Route::get($v[0]['plain'], ['as'=>$v[0]['plain'],'uses'=>$c->action.'@'.$k]);
                      } elseif ($v[0]['verb'] == 'post') {
                          if (preg_match('/[\s\S]+\/index/', $v[0]['plain'])) {
                              $v[0]['plain'] = str_replace('/index', '', $v[0]['plain']);
                          }
                          \Route::post($v[0]['plain'], ['as'=>$v[0]['plain'],'uses'=>$c->action.'@'.$k]);                          
                      }
                      
                 }
                 if($c->other_route!='') {
                     \Route::controller($c->other_route, $c->action);                     
                 }                                      
            }
        }
    }
}
