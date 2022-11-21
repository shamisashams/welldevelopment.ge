<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Attribute;
use App\Models\Certificate;
use App\Models\City;
use App\Models\Page;
use App\Models\Project;
use App\Repositories\Eloquent\ApartmentRepository;
use Inertia\Inertia;
use App\Repositories\Eloquent\GalleryRepository;

class ApartmentController extends Controller
{
    protected $apartmentRepository;

    public function __construct(ApartmentRepository $apartmentRepository){
        $this->apartmentRepository = $apartmentRepository;
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

        $apartments = $this->apartmentRepository->getAll();



        //dd($files);

        return Inertia::render('Apartments', [
            'filter' => $this->getAttributes(),
            "apartments" => $apartments,
            "page" => $page, "seo" => [
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


        $apartment = Apartment::query()->where('slug',$slug)->where('status',1)->with(['translation','latestImage','files','details.translation','project.translation','project.coverSlider','project.city.translation','project.district.translation'])->firstOrFail();

        $related_apartment = Apartment::query()->where('id','!=',$apartment->id)->where('status',1)->with(['translation','latestImage'])->limit(4)->inRandomOrder()->get();


        $project_apartments = $apartment->project->apartments()->with(['translation','latestImage'])->where('id','!=',$apartment->id)->get();

        $similar_apartments = Apartment::with(['translation','latestImage'])->where('id','!=',$apartment->id)->get();

        return Inertia::render('SingleApartment',[
            'apartment' => $apartment,
            "project_apartments" => $project_apartments,
            "similar_apartments" => $similar_apartments,
            'blog' => $apartment,
            'related_blogs' => $related_apartment,
            "seo" => [
                "title"=>$apartment->meta_title,
                "description"=>$apartment->meta_description,
                "keywords"=>$apartment->meta_keyword,
                "og_title"=>$apartment->meta_title,
                "og_description"=>$apartment->meta_description,
                "image" => $apartment->latestImage ? $apartment->latestImage->file_full_url : '',
//            "locale" => App::getLocale()
            ]
        ])->withViewData([
            'meta_title' => $apartment->meta_title,
            'meta_description' => $apartment->meta_description,
            'meta_keyword' => $apartment->meta_keyword,
            "image" => $apartment->latestImage ? $apartment->latestImage->file_full_url : '',
            'og_title' => $apartment->meta_title,
            'og_description' => $apartment->meta_description,
        ]);
    }

    public function offer()
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

        $apartments = $this->apartmentRepository->getAll(1);



        //dd($files);

        return Inertia::render('Apartments', [
            "apartments" => $apartments,
            'filter' => $this->getAttributes(),
            "page" => $page, "seo" => [
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
