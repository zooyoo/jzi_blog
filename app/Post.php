<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /*
     * 访问 Title 字段，进行 SEO 优化
     */
    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;

        if (!$this->exists){
            $this->attributes['slug'] = str_slug($value);
        }
    }
}
