<?php

namespace App\Http\Controllers\Client;

use App\Cart\Facade\Cart;
use App\Http\Controllers\Controller;
use App\Mail\PromocodeProduct;
use App\Models\Apartment;
use App\Models\Category;
use App\Models\MailTemplate;
use App\Models\Page;
use App\Models\Product;
use App\Promocode\Promocode;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\Eloquent\ProductRepository;
use Spatie\TranslationLoader\TranslationLoaders\Db;
use Illuminate\Support\Facades\Mail;

class FavoriteController extends Controller
{

    protected $productRepository;

    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $locale
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(string $locale, Request $request)
    {
        $page = Page::where('key', 'apartments')->firstOrFail();
        /*$products = Product::with(['files'])->whereHas('categories',function (Builder $query){
            $query->where('status', 1);
        })->paginate(16);*/

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }















            //dd($wishlist);
        //dd($products);
        return Inertia::render('Favorites',[
            'images' => $images,
            'page' => $page,
            "seo" => [
                "title"=>$page->meta_title,
                "description"=>$page->meta_description,
                "keywords"=>$page->meta_keyword,
                "og_title"=>$page->meta_og_title,
                "og_description"=>$page->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
            ]
        ])->withViewData([
            'meta_title' => $page->meta_title,
            'meta_description' => $page->meta_description,
            'meta_keyword' => $page->meta_keyword,
            "image" => $page->file,
            'og_title' => $page->meta_og_title,
            'og_description' => $page->meta_og_description
        ]);
    }


    /**
     * @param string $locale
     * @param string $slug
     * @return Application|Factory|View
     */
    public function show(string $locale, string $slug)
    {
        //\Illuminate\Support\Facades\DB::enableQueryLog();

        $product = Product::where(['status' => true, 'slug' => $slug])->whereHas('categories', function (Builder $query) {
            $query->where('status', 1);

        })->with(['latestImage'])->firstOrFail();

        $productImages = $product->files()->orderBy('id','desc')->get();

        $product_attributes = $product->attribute_values;

        $result = [];

        foreach ($product_attributes as $item){
            $options = $item->attribute->options;
            $value = '';
            foreach ($options as $option){
                if($item->attribute->type == 'select'){
                    if($item->integer_value == $option->id) {
                        $result[$item->attribute->code] = $option->label;
                    }

                }
            }

        }


        //dd(last($product->categories));
        $categories = $product->categories;


        $path = [];
        $arr = [];
        foreach ($categories as $key =>$item){


            $ancestors = $item->ancestors;
            if(count($ancestors)){
                foreach ($ancestors as $ancestor){
                    $arr[count($ancestors)]['ancestors'][] = $ancestor;
                    $arr[count($ancestors)]['current'] = $item;
                }
            } else {
                $arr[0]['ancestors'] = [];
                $arr[0]['current'] = $item;
            }



            /*if($item->isLeaf()){

                $ancestors = $item->ancestors;

                $k = 0;
                foreach ($ancestors as $ancestor){
                    $path[$k]['id'] = $ancestor->id;
                    $path[$k]['slug'] = $ancestor->slug;
                    $path[$k]['title'] = $ancestor->title;
                    $k++;
                }

                $path[$k]['id'] = $item->id;
                $path[$k]['slug'] = $item->slug;
                $path[$k]['title'] = $item->title;
                break;
            } else {

            }*/

        }

        $max = max(array_keys($arr));

        $k = 0;
        foreach ($arr[$max]['ancestors'] as $ancestor){
            $path[$k]['id'] = $ancestor->id;
            $path[$k]['slug'] = $ancestor->slug;
            $path[$k]['title'] = $ancestor->title;
            $k++;
        }

        $path[$k]['id'] = $arr[$max]['current']->id;
        $path[$k]['slug'] = $arr[$max]['current']->slug;
        $path[$k]['title'] = $arr[$max]['current']->title;
        //dd($path);


        $similar_products = Product::where(['status' => 1, 'product_categories.category_id' => $path[0]['id']])
            ->where('products.id','!=',$product->id)
            ->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->inRandomOrder()
            ->with('latestImage')->get();
        //dd($category);
        //$result = [];
        //$result['id'] = $category[0]['id'];
        //$result['title'] = $category[0]['title'];
        //dd(\Illuminate\Support\Facades\DB::getQueryLog());

        /*return view('client.pages.product.show', [
            'product' => $product
        ]);*/
        return Inertia::render('ProductDetails/ProductDetails',[
            'product' => $product,
            'category_path' => $path,
            'similar_products' => $similar_products,
            'product_images' => $productImages,
            'product_attributes' => $result,
            "seo" => [
                "title"=>$product->meta_title,
                "description"=>$product->meta_description,
                "keywords"=>$product->meta_keyword,
                "og_title"=>$product->meta_og_title,
                "og_description"=>$product->meta_og_description,
//            "image" => "imgg",
//            "locale" => App::getLocale()
            ]
        ])->withViewData([
            'meta_title' => $product->meta_title,
            'meta_description' => $product->meta_description,
            'meta_keyword' => $product->meta_keyword,
            "image" => $product->file,
            'og_title' => $product->meta_og_title,
            'og_description' => $product->meta_og_description
        ]);
    }

    public function addToCart(Request $request){
        //dd($request->all());

        Cart::add($request);

    }

    public function removeFromCart(Request $request){
        Cart::remove($request);
        return redirect()->back();
    }

    public function getCart(){

        return Cart::getCart();
    }

    public function updateCart(Request $request){
        Cart::update($request);
        return redirect()->back();
    }

    public function addToWishlist(Request $request){
        $product = Product::query()->where('id',$request->post('id'))->first();

        if($product->promocode){
            if($product->promocode->status){
                $promo_gen = new Promocode();
                if($request->user()->promocode()->where('promocode_id',$product->promocode->id)->count() === 0){
                    $gen = $promo_gen->generateCode();
                    $request->user()->promocode()->create(['promocode_id' => $product->promocode->id, 'promocode' => $gen]);

                    $data['product'] = $product;
                    $data['text'] = MailTemplate::query()->first()->promocode_products;
                    $data['code'] = $gen;
                    Mail::to($request->user())->send(new PromocodeProduct($data));
                }
            }


        }
        $request->user()->wishlist()->updateOrCreate(['product_id' => $request->post('id')]);
        return redirect()->back();
    }

    public function addToWishlistCollection(Request $request){

        $request->user()->wishlist()->updateOrCreate(['product_set_id' => $request->post('id')]);
        return redirect()->back();
    }

    public function removeFromWishlist(Request $request){
        $request->user()->wishlist()->where('product_id', $request->get('id'))->orWhere('product_set_id', $request->get('id'))->delete();
        return redirect()->back();
    }

    public function getFavorites(Request $request){

        return Apartment::with(['translation','latestImage'])->whereIn('id',$request->get('product_id'))->get();
    }

}
