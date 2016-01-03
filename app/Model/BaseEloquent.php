<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BaseEloquent extends Model {
    
    
    public $timestamps = false; // 控制自动时间戳; 默认为false
    
    protected function getDateFormat() {
        return 'U';
    }    
    
    // 整理单条记录排序
    public static function makeOrder($id, $order_by = 0) {
        $row = self::find($id);
        if (!$row) return false;
        
        $max = self::get()->count();
        if ($order_by < 1) {
            $order_by = $max;
        } elseif ($order_by > $max) {
            $order_by = $max;
        }
        $rows = self::where('id', '!=', $row->id)
            ->orderBy('order_by')->get();
        
        if ($rows) {
            $order_num = 1;
            foreach ($rows as $v) {
                if ($order_num == $order_by) 
                    $order_num++;
                
                $_row = self::find($v->id);
                $_row->order_by = $order_num;
                $_row->save();
                
                $order_num++;
            }
        }
                
        $row->order_by = $order_by;
        $row->save();
        
        return true;
    }
    // 重新排序
    public static function makeOrderAll() {
        $rows = self::orderBy('order_by')->get();
        
        if ($rows) {
            $order_num = 1;
            foreach ($rows as $v) {
                $_row = self::find($v->id);
                $_row->order_by = $order_num;
                $_row->save();
                
                $order_num++;
            }
        }
    }
}