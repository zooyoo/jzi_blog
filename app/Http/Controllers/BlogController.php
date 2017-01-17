<?php

namespace App\Http\Controllers;

use App\Repositories\BlogRepository;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Jobs\BlogIndexData;
use App\Services\RssFeed;
use App\Services\SiteMap;

class BlogController extends Controller
{
    protected $blog;

    public function __construct(BlogRepository $blog)
    {
        $this->blog = $blog;
    }

//    public function index(){
//        //直接查询写法
//        /*$posts = Post::where('updated_at', '<=', Carbon::now())
//            ->orderBy('updated_at', 'desc')
//            ->paginate(config('blog.posts_per_page'));
//
//        return view('blog.index', compact('posts'));*/
//
//        //依赖注入写法
//        /*return view('blog.index', [
//            'posts' => $this->blog->getAllPost(),
//        ]);*/
//
//        //with写法
//        return view('blog.index')->withPosts($this->blog->getAllPost());
//    }

//    public function showPost($slug){
//        /*$post = Post::whereSlug($slug)->firstOrFail();
//        return view('blog.post')->withPost($post);*/
//
//        return view('blog.post')->withPost($this->blog->GetPostBySlug($slug));
//    }

    //任务类写法
    public function index(Request $request)
    {
        $tag = $request->get('tag');
        $data = $this->dispatch(new BlogIndexData($tag));
        $layout = $tag ? Tag::layout($tag) : 'blog.layouts.index';

        return view($layout, $data);
    }

    public function showPost($slug, Request $request)
    {
        $post = Post::with('tags')->whereSlug($slug)->firstOrFail();
        $tag = $request->get('tag');
        if ($tag) {
            $tag = Tag::whereTag($tag)->firstOrFail();
        }

        return view($post->layout, compact('post', 'tag', 'slug'));
    }


    public function rss(RssFeed $feed)
    {
        $rss = $feed->getRSS();

        return response($rss)
            ->header('Content-type', 'application/rss+xml');
    }


    public function siteMap(SiteMap $siteMap)
    {
        $map = $siteMap->getSiteMap();

        return response($map)
            ->header('Content-type', 'text/xml');
    }
}
