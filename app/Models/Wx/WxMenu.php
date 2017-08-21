<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

class WxMenu extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'wxmenu';

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
            case 'miniprogram':
                $typename = '小程序';
                break;

            case 'view_limited':
                $typename = '图文消息URL';
                break;

            case 'media_id':
                $typename = '下发消息';
                break;


            case 'location_select':
                $typename = '地址位置';
                break;

            case 'pic_weixin':
                $typename = '微信相册发图器';
                break;

            case 'pic_photo_or_album':
                $typename = '拍照或相册';
                break;

            case 'pic_sysphoto':
                $typename = '拍照';
                break;
            
            case 'scancode_waitmsg':
                $typename = '扫码带提示';
                break;

            case 'scancode_push':
                $typename = '扫码';
                break;

            case 'view':
                $typename = '链接';
                break;

            default:
                $typename = '关键字';
                break;
        }
        return $typename;
    }
}
