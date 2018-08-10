<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Hash extends Model
{
    use Searchable;

    public $table = 'search_hash';

    public $timestamps = false;


    /**
     * 关联文件列表模型
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fileList()
    {
        return $this->hasOne('App\HashList','info_hash','info_hash');
    }

    /**
     * 定义索引里面的type
     * @return string
     */
    public function searchableAs()
    {
        return "post";
    }

    /**
     * 定义有哪些字段需要搜索
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'info_hash' => $this->info_hash,
            'length' => $this->length,
            'id' => $this->id,
            'requests' => $this->requests
        ];
    }

}
