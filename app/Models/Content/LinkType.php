<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2021-03-16 10:11:52
 * @Description: 友情链接分类
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-03-16 10:13:18
 * @FilePath: /CoinCMF/app/Models/Content/LinkType.php
 */

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Model;

class LinkType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'link_types';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    protected $casts = [
        'id' => 'integer'
    ];
    // 关联
    public function links()
    {
        return $this->hasMany(Link::class, 'linktype_id', 'id');
    }
}
