<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Page;
use App\Models\Project;
use Inertia\Inertia;
use App\Repositories\Eloquent\GalleryRepository;

class ProjectController extends Controller
{
    protected $galleryRepository;

    public function __construct(GalleryRepository $galleryRepository){
        $this->galleryRepository = $galleryRepository;
    }

    public function index()
    {
        $page = Page::where('key', 'about')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $files = [];
        if($page->images) $files = $page->files;

        //dd($files);

        return Inertia::render('About', ["page" => $page, "seo" => [
            "title"=>$page->meta_title,
            "description"=>$page->meta_description,
            "keywords"=>$page->meta_keyword,
            "og_title"=>$page->meta_og_title,
            "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
        ], 'gallery_img' => $files,'images' => $images])->withViewData([
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


        $project = Project::query()->where('slug',$slug)->where('status',1)->with(['translation','latestImage','slider','details.translation','city.translation','district.translation'])->firstOrFail();

        $project_apartments = $project->apartments()->with(['translation','latestImage'])->paginate(6);



        //dd($project);
        $related_project = Project::query()->where('id','!=',$project->id)->where('status',1)->with(['translation','latestImage'])->inRandomOrder()->get();



        return Inertia::render('SingleProject',[
            'product' => null,
            'category_path' => null,
            'similar_products' => null,
            'product_images' => null,
            'product_attributes' => null,
            'project' => $project,
            'related_projects' => $related_project,
            'project_apartments' => $project_apartments,
            "seo" => [
                "title"=>$project->meta_title,
                "description"=>$project->meta_description,
                "keywords"=>$project->meta_keyword,
                "og_title"=>$project->meta_title,
                "og_description"=>$project->meta_description,
                "image" => $project->latestImage ? $project->latestImage->file_full_url : '',
//            "locale" => App::getLocale()
            ]
        ])->withViewData([
            'meta_title' => $project->meta_title,
            'meta_description' => $project->meta_description,
            'meta_keyword' => $project->meta_keyword,
            "image" => $project->latestImage ? $project->latestImage->file_full_url : '',
            'og_title' => $project->meta_title,
            'og_description' => $project->meta_description,
        ]);
    }
}
