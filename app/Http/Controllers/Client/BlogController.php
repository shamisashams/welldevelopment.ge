<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Certificate;
use App\Models\Page;
use Inertia\Inertia;
use App\Repositories\Eloquent\GalleryRepository;

class BlogController extends Controller
{
    protected $galleryRepository;

    public function __construct(GalleryRepository $galleryRepository){
        $this->galleryRepository = $galleryRepository;
    }

    public function index()
    {
        $page = Page::where('key', 'blogs')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $files = [];

        $last_blog = Blog::with(['translation','latestImage'])->latest('created_at')->first();

        //dd($last_blog);

        $blogs = [
            'data' => [],
            'links' => []
        ];

        if ($last_blog)
        $blogs = Blog::orderBy('created_at','desc')->with(['translation','latestImage'])->where('id','!=',$last_blog->id)->paginate(8);
        //dd($blogs);
        //dd($blogs);

        return Inertia::render('Blogs', ["page" => $page,
            "last_blog" => $last_blog,
            "seo" => [
            "title"=>$page->meta_title,
            "description"=>$page->meta_description,
            "keywords"=>$page->meta_keyword,
            "og_title"=>$page->meta_og_title,
            "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
        ], 'blogs' => $blogs,'blog_images' => $files, 'images' => $images])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
    }

    public function show(string $locale, string $slug)
    {
        //\Illuminate\Support\Facades\DB::enableQueryLog();


        $blog = Blog::query()->where('slug',$slug)->with(['translation','latestImage'])->firstOrFail();

        $related_blogs = Blog::query()->where('id','!=',$blog->id)->with(['translation','latestImage'])->limit(8)->inRandomOrder()->get();



        return Inertia::render('SingleBlog',[
            'blog' => $blog,
            'related_blogs' => $related_blogs,
            "seo" => [
                "title"=>$blog->meta_title,
                "description"=>$blog->meta_description,
                "keywords"=>$blog->meta_keyword,
                "og_title"=>$blog->meta_title,
                "og_description"=>$blog->meta_description,
                "image" => $blog->latestImage ? $blog->latestImage->file_full_url : '',
//            "locale" => App::getLocale()
            ]
        ])->withViewData([
            'meta_title' => $blog->meta_title,
            'meta_description' => $blog->meta_description,
            'meta_keyword' => $blog->meta_keyword,
            "image" => $blog->latestImage ? $blog->latestImage->file_full_url : '',
            'og_title' => $blog->meta_title,
            'og_description' => $blog->meta_description,
        ]);
    }
}
