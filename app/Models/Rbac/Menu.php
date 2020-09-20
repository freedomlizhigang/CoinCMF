<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 菜单表
 * @LastEditors: 李志刚
 * @LastEditTime: 2020-09-20 19:57:38
 * @FilePath: /CoinCMF/app/Models/Rbac/Menu.php
 */

namespace App\Models\Rbac;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'menus';

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
     * 应该被转换成原生类型的属性。
     *
     * @var array
     */
    protected $casts = [
        'display' => 'boolean',
        'sort' => 'integer',
    ];

    // 关联role表
    public function role()
    {
        return $this->belongsToMany('\App\Models\Rbac\Role','role_privs');
    }
}
