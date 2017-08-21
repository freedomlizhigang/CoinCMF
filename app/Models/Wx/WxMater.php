<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

class WxMater extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'wxmater';

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
    
    // 类型名
    public function getTypenameAttribute()
    {
        switch ($this->attributes['type']) {
            case 'voice':
                $typename = '声音';
                break;
            
            case 'video':
                $typename = '视频';
                break;

            case 'news':
                $typename = '图文';
                break;

            case 'thumb':
                $typename = '缩略图';
                break;

            default:
                $typename = '图片';
                break;
        }
        return $typename;
    }

    // 把content解析成正常数组
    public function getContentAttribute()
    {
        return json_decode($this->attributes['content'],true);
    }


    // 自动回复
    public function reply()
    {
        return $this->hasMany('\App\Models\Wx\Reply','mid','id');
    }
}
