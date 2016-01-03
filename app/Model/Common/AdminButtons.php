<?php
namespace App\Model\Common;

trait AdminButtons {
    
    // 图片
    public function ab_t($id, $proute, $other = "") {
        return view('admin.common.ab-t'
                        , compact('id', 'proute', 'other'))->render();
    }

    // 文字按钮
    public function ab_b($id, $proute, $other = "") {
        return view('admin.common.ab-b'
                        , compact('id', 'proute', 'other'))->render();
    }

    // 图片文字按钮
    public function ab_tb($id, $proute, $other = "") {
        return view('admin.common.ab-tb'
                        , compact('id', 'proute', 'other'))->render();
    }
}