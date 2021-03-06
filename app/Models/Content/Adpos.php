<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2018-06-26 11:29:14
 * @Description: 广告位表
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-21 15:03:15
 * @FilePath: /CoinCMF/app/Models/Content/Adpos.php
 */

namespace App\Models\Content;

use App\Models\Content\Ad;
use Illuminate\Database\Eloquent\Model;

class Adpos extends Model
{
    // 广告位
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'ad_pos';

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
        'is_mobile' => 'boolean'
    ];
    // 关联
    public function ads()
    {
        return $this->hasMany(Ad::class, 'pos_id', 'id');
    }
}
