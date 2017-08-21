<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'wxreply';

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

    // 把keyword解析成正常数组
    public function getKeywordAttribute()
    {
        $keyword = trim($this->attributes['keyword'],'_');
        $keyword = str_replace('_',PHP_EOL,$keyword);
        return $keyword;
    }

    // 类型名
    public function getTypenameAttribute()
    {
        switch ($this->attributes['replytype']) {
            case 'voice':
                $typename = '声音';
                break;
            
            case 'video':
                $typename = '视频';
                break;

            case 'news':
                $typename = '图文';
                break;

            case 'image':
                $typename = '缩略图';
                break;

            default:
                $typename = '文本';
                break;
        }
        return $typename;
    }

    /**
     * 素材
     */
    public function mater()
    {
        return $this->belongsTo('\App\Models\Wx\WxMater','mid','id');
    }
}
