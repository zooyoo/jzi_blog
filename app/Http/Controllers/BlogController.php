<?php

namespace App\Http\Controllers;

use App\Repositories\BlogRepository;
use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blog;

    public function __construct(BlogRepository $blog)
    {
        $this->blog = $blog;
    }

    public function index(){
        //直接查询写法
        /*$posts = Post::where('updated_at', '<=', Carbon::now())
            ->orderBy('updated_at', 'desc')
            ->paginate(config('blog.posts_per_page'));

        return view('blog.index', compact('posts'));*/

        //依赖注入写法
        /*return view('blog.index', [
            'posts' => $this->blog->getAllPost(),
        ]);*/

        //with写法
        return view('blog.index')->withPosts($this->blog->getAllPost());
    }

    public function showPost($slug){
        /*$post = Post::whereSlug($slug)->firstOrFail();
        return view('blog.post')->withPost($post);*/

        return view('blog.post')->withPost($this->blog->GetPostBySlug($slug));
    }
}
