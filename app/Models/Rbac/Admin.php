<?php
/*
 * @Author: 李志刚
 * @CopyRight: 2020-2030 衡水山木枝技术服务有限公司
 * @Date: 2019-01-03 20:14:16
 * @Description: 系统管理员表
 * @LastEditors: 李志刚
 * @LastEditTime: 2021-03-15 16:15:29
 * @FilePath: /CoinCMF/app/Models/Rbac/Admin.php
 */

namespace App\Models\Rbac;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'admins';

    // 不可以批量赋值的字段，为空则表示都可以
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'crypt',
    ];

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
    ];

    /**
     * 用户组
     */
    public function role()
    {
        return $this->belongsToMany('\App\Models\Rbac\Role','role_admins','admin_id','role_id');
    }

    // 关联
    public function department()
    {
        return $this->belongsToMany('\App\Models\Rbac\Department','department_admins','admin_id', 'department_id');
    }
}
