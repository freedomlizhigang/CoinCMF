<?php
/*
 * @package [App\Models\Console]
 * @author [李志刚]
 * @createdate  [2018-10-24]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 模型
 *
 */
namespace App\Models\Console;

use Illuminate\Database\Eloquent\Model as M;

class Model extends M
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'models';

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

    // 关联字段表
    public function fields()
    {
        return $this->hasMany('\App\Models\Console\ModelField','model_id','id');
    }
}
