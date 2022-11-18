<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Attribute;
use App\Models\Blog;
use App\Models\City;
use App\Models\Page;
use App\Models\Product;
use App\Models\Project;
use App\Models\Slider;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use App\Repositories\Eloquent\ProductRepository;


class HomeController extends Controller
{
    public function index()
    {


        $page = Page::where('key', 'home')->firstOrFail();

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        $sliders = Slider::query()->where("status", 1)->with(['file', 'translations','project.translation','project.apartments'])->get();
//        dd($page->file);
       //dd($sliders);

        $projects = Project::with(['translation','latestImage'])->get();


        $apartments = Apartment::with(['translation','latestImage'])->where('offer',1)->limit(8)->get();

        $blogs = Blog::with(['translation','latestImage'])->limit(8)->inRandomOrder()->get();

        //dd($apartments);

        //dd($products);

        return Inertia::render('Home', [
            'filter' => $this->getAttributes(),
            "sliders" => $sliders,
            "projects" => $projects,
            "apartments" => $apartments,
            "blogs" => $blogs,
            "page" => $page,
            "seo" => [
            "title"=>$page->meta_title,
            "description"=>$page->meta_description,
            "keywords"=>$page->meta_keyword,
            "og_title"=>$page->meta_og_title,
            "og_description"=>$page->meta_og_description,

//            "image" => "imgg",
//            "locale" => App::getLocale()
        ],'images' => $images])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);

    }

    private function getAttributes():array{
        $attrs = Attribute::with(['translation','options.translation'])->orderBy('position')->get();
       // dd($attrs);
        $result['attributes'] = [];
        $key = 0;
        foreach ($attrs as $item){
            $result['attributes'][$item->code]['id'] = $item->id;
            $result['attributes'][$item->code]['name'] = $item->name;
            $result['attributes'][$item->code]['code'] = $item->code;
            $result['attributes'][$item->code]['type'] = $item->type;
            $_options = [];
            $_key = 0;
            foreach ($item->options as $option){
                $_options[$_key]['id'] = $option->id;
                $_options[$_key]['label'] = $option->label;
                $_key++;
            }
            $result['attributes'][$item->code]['options'] = $_options;
            $key++;
        }

        $result['cities'] = $this->getCitiesWithDistricts();

        //dd($result);
        return $result;
    }


    public function getCitiesWithDistricts(){
        $cities = City::with(['translation','districts.translation'])->get();
        return $cities;
    }

}
