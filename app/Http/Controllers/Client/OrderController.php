<?php

namespace App\Http\Controllers\Client;

use App\BogPay\BogPay;
use App\BogPay\BogPaymentController;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Page;
use App\Models\Product;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;
use App\Repositories\Eloquent\ProductRepository;
use Spatie\TranslationLoader\TranslationLoaders\Db;
use Illuminate\Support\Facades\DB as DataBase;

class OrderController extends Controller
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
        $page = Page::where('key', 'products')->firstOrFail();
        $products = Product::with(['files'])->whereHas('categories',function (Builder $query){
            $query->where('status', 1);
        })->paginate(16);

        $images = [];
        foreach ($page->sections as $sections){
            if($sections->file){
                $images[] = asset($sections->file->getFileUrlAttribute());
            } else {
                $images[] = null;
            }

        }

        //dd($products);
        return Inertia::render('OrderForm/OrderForm',[
            'products' => $products,
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

    public function order(Request $request){
        //dd($request->all());
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'city' => 'required',
            'address' => 'required',
            'payment_method' => 'required',
            'payment_type' => 'required_if:payment_method,1'
        ]);

        $data = $request->all();
        $cart = Arr::pull($data,'cart');
        $data['locale'] = app()->getLocale();
        $data['grand_total'] = $cart['total'];



        $product_ids = [];
        foreach ($cart['items'] as $item){
            $product_ids[] = $item['product']['id'];
        }

        $products = Product::whereIn('id',$product_ids)->get();

        if($products){
            $prod_data = [];
            foreach ($products as $product){
                $prod_data[$product->id]['qty'] = $product->quantity;
                $prod_data[$product->id]['status'] = $product->status;
                $prod_data[$product->id]['price'] = $product->price;
                $prod_data[$product->id]['special_price'] = $product->special_price;
            }

            $error = true;
            foreach ($cart['items'] as $item){
                if(isset($prod_data[$item['product']['id']])){
                    $price = ($prod_data[$item['product']['id']]['special_price'] !== null) ? $prod_data[$item['product']['id']]['special_price'] : $prod_data[$item['product']['id']]['price'];
                    if ($prod_data[$item['product']['id']]['qty'] >= $item['qty'] && $price == $item['product']['price'] && $prod_data[$item['product']['id']]['status'] == 1){
                        $error = false;
                    }
                } else {
                    $error = true;
                    break;
                }
            }

            //dd($prod_data);

            if ($error){
                 dd('error cart is not valid');
            }

            try {
                DataBase::beginTransaction();
                $order = Order::create($data);

                $data = [];
                $insert = [];
                foreach ($cart['items'] as $item){
                    $data['order_id'] = $order->id;
                    $data['product_id'] = $item['product']['id'];
                    $data['name'] = $item['product']['title'];
                    $data['qty_ordered'] = $item['qty'];
                    $data['price'] = $item['product']['price'];
                    $data['total'] = $item['product']['price'] * $item['qty'];
                    $insert[] = $data;
                }
                //dd($insert);
                OrderItem::insert($insert);



                DataBase::commit();



                if($order->payment_method == 1 && $order->payment_type == 'bog'){
                    return app(BogPaymentController::class)->make_order($order->id,$order->grand_total);
                } elseif($order->payment_method == 1 && $order->payment_type == 'tbc'){
                    return redirect(locale_route('order.failure',$order->id));
                }
                 else {
                    return redirect(locale_route('order.success',$order->id));
                }

            } catch (QueryException $exception){
                DataBase::rollBack();
            }


        }

    }

    public function bogResponse(Request $request){
        //dump($request->order_id);
        $order = Order::query()->where('id',$request->get('order_id'))->first();

        //dd($order);
        if($order->status == 'success') return redirect(locale_route('order.success',$order->id));
        else if($order->status == 'error') return redirect(route('order.failure'));
        else {
            sleep(3);
            return redirect('https://bunkeri1.ge/' . app()->getLocale() . '/payments/bog/status?order_id='.$order->id);
        }
    }

    public function statusSuccess($order_id){
        $order = Order::query()->where('id',$order_id)->with('items')->first();
        return Inertia::render('Success/Success',['order' => $order])->withViewData([
            'meta_title' => 'success',
            'meta_description' => 'success',
            'meta_keyword' => 'success',
            "image" => '',
            'og_title' => 'success',
            'og_description' => 'success',
        ]);
    }

    public function statusFail($order_id){
        return Inertia::render('Success/Failure',[])->withViewData([
            'meta_title' => 'success',
            'meta_description' => 'success',
            'meta_keyword' => 'success',
            "image" => '',
            'og_title' => 'success',
            'og_description' => 'success',
        ]);
    }

}
