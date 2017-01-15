<?php
namespace App\Repositories;

use App\Post;
use Carbon\Carbon;

class BlogRepository
{
    //获取所有文章
    public function getAllPost(){
        return Post::where('updated_at', '<=', Carbon::now())
            ->orderBy('updated_at', 'desc')
            ->paginate(config('blog.posts_per_page'));
    }

    //按 slug 字段获取文章
    public  function GetPostBySlug($slug){
        return Post::whereSlug($slug)->firstOrFail();
    }
}