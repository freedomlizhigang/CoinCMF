<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2018-06-26 09:08:02
 * @Description: 用户权限表
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 19:58:00
 * @FilePath: /CoinCMF/app/Models/Rbac/Priv.php
 */

namespace App\Models\Rbac;

use Illuminate\Database\Eloquent\Model;

class Priv extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'role_privs';

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
