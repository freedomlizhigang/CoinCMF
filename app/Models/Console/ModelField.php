<?php
/*
 * @package [App\Models\Console]
 * @author [李志刚]
 * @createdate  [2018-10-24]
 * @copyright [2018-2020 衡水希夷信息技术工作室]
 * @version [1.0.0]
 * @directions 模型字段
 *
 */
namespace App\Models\Console;

use Illuminate\Database\Eloquent\Model;

class ModelField extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'model_fields';

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

    // 关联模型表
    public function model()
    {
        return $this->belongsTo('\App\Models\Console\Model','model_id','id');
    }
}
