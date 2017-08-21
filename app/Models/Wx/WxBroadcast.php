<?php

namespace App\Models\Wx;

use App\Models\Wx\WxUser;
use Illuminate\Database\Eloquent\Model;

class WxBroadcast extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'wxbroadcast';

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
    // 用户昵称
    public function getOpenidNameAttribute()
    {
        $openids = json_decode($this->attributes['openids'],true);
        $names = WxUser::whereIn('openid',$openids)->pluck('nickname')->toArray();
        $names = implode(' , ', $names);
        return $names;
    }
}
