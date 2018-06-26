<?php
/*
 * @package [App\Models\Common]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 广告
 *
 */
namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    // 广告
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'ads';

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
}
