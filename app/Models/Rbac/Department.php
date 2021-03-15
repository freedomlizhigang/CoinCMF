<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 部门表
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-03-15 16:13:11
 * @FilePath: /CoinCMF/app/Models/Rbac/Department.php
 */

namespace App\Models\Rbac;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'departments';

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
        'status' => 'boolean',
        'del_flag' => 'boolean',
    ];

    /**
     * 用户
     */
    public function Admin()
    {
        return $this->belongsToMany('\App\Models\Rbac\Admin', 'department_admins', 'department_id', 'admin_id');
    }
}
