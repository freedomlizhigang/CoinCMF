<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{

    use Searchable;

    // 不可以批量赋值的字段，为空则表示都可以
    protected $guarded = [];

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $hidden = [];

    /**
     * 搜索索引
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'articles_index';
    }

    /**
     * 索引数据
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->only('id', 'title', 'describe', 'content');
    }

    // 关联categorys
    public function cate()
    {
        return $this->belongsTo('\App\Models\Common\Cate','catid','id');
    }
}