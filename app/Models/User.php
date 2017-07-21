<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // 用户表
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'users';

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

    // 增加会员等级的属性
    protected $appends = ['groupname'];

    public function getGroupnameAttribute()
    {
        $points = $this->attributes['points'];
        try {
            $groups = collect(cache('group'))->sortByDesc('points');
            $groupname = $groups->where('points','<=',$points)->first()['name'];
        } catch (\Exception $e) {
            $groupname = '普通用户';
        }
        return $groupname;
    }
}
