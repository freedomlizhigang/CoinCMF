<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2018-06-26 09:06:52
 * @Description: 广告表
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-21 15:04:24
 * @FilePath: /CoinCMF/app/Models/Content/Ad.php
 */

namespace App\Models\Content;

use App\Models\Content\Adpos;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
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
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pos_id' => 'integer',
        'sort' => 'integer',
        'status' => 'boolean'
    ];
    // 关联
    public function ad_pos()
    {
        return $this->belongsTo(Adpos::class, 'pos_id', 'id');
    }
}
