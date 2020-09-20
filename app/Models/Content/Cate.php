<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2018-06-26 10:19:48
 * @Description: 栏目表
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 19:54:51
 * @FilePath: /CoinCMF/app/Models/Content/Cate.php
 */

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'categorys';

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

    // 关联articles表
    public function article()
    {
        return $this->hasMany('\App\Models\Content\Article','cate_id','id');
    }

}
