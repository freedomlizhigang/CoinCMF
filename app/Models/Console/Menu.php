<?php
/*
 * @package [App\Models\Console]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 菜单-权限
 *
 */
namespace App\Models\Console;

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

    // 关联role表
    public function role()
    {
        return $this->belongsToMany('\App\Models\Console\Role','role_privs');
    }
}
