<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 文章表
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-21 11:29:10
 * @FilePath: /CoinCMF/app/Models/Content/Article.php
 */

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'articles';

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
        'cate_id' => 'integer',
        'push_flag' => 'boolean',
        'link_flag' => 'boolean',
        'sort' => 'integer',
        'hits' => 'integer',
        'del_flag' => 'integer'
    ];
    // 关联categorys
    public function cate()
    {
        return $this->belongsTo('\App\Models\Content\Cate','cate_id','id');
    }
}