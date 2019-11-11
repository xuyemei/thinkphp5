<?php
namespace app\common\validate;

use think\Validate;

class Newss extends Validate {
    protected $rule = [
        'title'=>'require|max:100',
        'small_title'=>'require|max:100',
        'catid'=>'require|number',
        'is_allow_comments'=>'number',
        'description'=>'require',
        'content'=>'require',
    ];
}