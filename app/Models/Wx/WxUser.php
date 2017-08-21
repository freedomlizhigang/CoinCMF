<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

class WxUser extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'wxuser';

    // 不可以批量赋值的字段，为空则表示都可以
    protected $guarded = [];

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $hidden = [];
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * 用户标签
     */
    public function tag()
    {
        return $this->belongsToMany('\App\Models\Wx\WxTag','wxuser_tag','u_id','t_id');
    }
}
