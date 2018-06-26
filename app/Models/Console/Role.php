<?php
/*
 * @package [App\Models\Console]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 角色
 *
 */
namespace App\Models\Console;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'roles';

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
     * 用户
     */
    public function Admin()
    {
        return $this->belongsToMany('\App\Models\Console\Admin','role_users','role_id','user_id');
    }

    // 关联privs表
    public function priv()
    {
        return $this->belongsToMany('\App\Models\Console\Priv','role_privs');
    }
}
