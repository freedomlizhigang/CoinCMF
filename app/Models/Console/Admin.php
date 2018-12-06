<?php
/*
 * @package [App\Models\Console]
 * @author [李志刚]
 * @createdate  [2018-06-26]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 管理员
 *
 */
namespace App\Models\Console;

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
        return $this->belongsToMany('\App\Models\Console\Role','role_users','user_id','role_id');
    }

    // 关联
    public function section()
    {
        return $this->belongsTo('\App\Models\Console\Section','section_id','id');
    }
}
