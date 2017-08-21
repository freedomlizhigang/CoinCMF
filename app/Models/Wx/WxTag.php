<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

class WxTag extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'wxtags';

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
     * 用户
     */
    public function user()
    {
        return $this->belongsToMany('\App\Models\Wx\WxUser','wxuser_tag','t_id','u_id');
    }
}
