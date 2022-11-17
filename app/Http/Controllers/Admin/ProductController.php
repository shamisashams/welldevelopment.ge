<?php
/**
 *  app/Http/Controllers/Admin/ProductController.php
 *
 * Date-Time: 30.07.21
 * Time: 10:37
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\ProductAttributeValueRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use ReflectionException;
use App\Repositories\Eloquent\AttributeRepository;
use function Symfony\Component\Translation\t;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */

    private $attributeRepository;

    private $productAttributeValueRepository;

    private $categories;
    public function __construct(
        ProductRepositoryInterface  $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        AttributeRepository $attributeRepository,
        ProductAttributeValueRepository $productAttributeValueRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categories = $this->categoryRepository->getCategoryTree();
        $this->attributeRepository = $attributeRepository;
        $this->productAttributeValueRepository = $productAttributeValueRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(ProductRequest $request)
    {
        /*return view('admin.pages.product.index', [
            'products' => $this->productRepository->getData($request, ['translations', 'categories'])
        ]);*/

        return view('admin.nowa.views.products.index', [
            'data' => $this->productRepository->getData($request, ['translations', 'categories']),
            'categories' => $this->categoryRepository->model->leftJoin('category_translations',function ($join){
                $join->on('category_translations.category_id','categories.id')->where('category_translations.locale',app()->getLocale());
            })->orderBy('title')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $product = $this->productRepository->model;





        $url = locale_route('product.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.products.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories,
            'attributes' => $this->attributeRepository->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function store(ProductRequest $request)
    {

        //dd($request->all());
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['stock'] = isset($saveData['stock']) && (bool)$saveData['stock'];
        $saveData['popular'] = isset($saveData['popular']) && (bool)$saveData['popular'];
        $saveData['new'] = isset($saveData['new']) && (bool)$saveData['new'];
        $saveData['new_collection'] = isset($saveData['new_collection']) && (bool)$saveData['new_collection'];
        $saveData['bunker'] = isset($saveData['bunker']) && (bool)$saveData['bunker'];
        $saveData['day_price'] = isset($saveData['day_price']) && (bool)$saveData['day_price'];
        $saveData['day_product'] = isset($saveData['day_product']) && (bool)$saveData['day_product'];
        $saveData['special_price_tag'] = isset($saveData['special_price_tag']) && (bool)$saveData['special_price_tag'];

        $attributes = $saveData['attribute'];
        unset($saveData['attribute']);

        $product = $this->productRepository->create($saveData);
        $product->categories()->sync($saveData['categories']);

        // Save Files
        if ($request->hasFile('images')) {
            $product = $this->productRepository->saveFiles($product->id, $request);
        }


        //save product attributes
        $attr = [];
        foreach ($attributes as $key => $item){
            if ($item){
                $attr[$key] = $item;
            }
        }

        $attr_ids = array_keys($attr);

        $_attributes = Attribute::whereIn('id',$attr_ids)->get();

        $arr = [];
        foreach ($_attributes as $item){
            $arr[$item->id] = $item;
        }

        $data = [];
        foreach ($attr as $key => $item){
            $data['product_id'] = $product->id;
            $data['attribute_id'] = $arr[$key]->id;
            $data['type'] = $arr[$key]->type;
            if($data['type'] == 'boolean') $data['value'] = (bool)$item;
            else $data['value'] = $item;

            //dd($data);
            $this->productAttributeValueRepository->create($data);
        }



        return redirect(locale_route('product.index', $product->id))->with('success', __('admin.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param string $locale
     * @param Product $product
     *
     * @return Application|Factory|View
     */
    public function show(string $locale, Product $product)
    {
        return view('admin.pages.product.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param Category $category
     *
     * @return Application|Factory|View
     */
    public function edit(string $locale, Product $product)
    {
        $url = locale_route('product.update', $product->id, false);
        $method = 'PUT';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.products.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories,
            'attributes' => $this->attributeRepository->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param string $locale
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function update(ProductRequest $request, string $locale, Product $product)
    {
        //dd($request->all());
        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['popular'] = isset($saveData['popular']) && (bool)$saveData['popular'];
        $saveData['stock'] = isset($saveData['stock']) && (bool)$saveData['stock'];
        $saveData['new'] = isset($saveData['new']) && (bool)$saveData['new'];
        $saveData['new_collection'] = isset($saveData['new_collection']) && (bool)$saveData['new_collection'];
        $saveData['bunker'] = isset($saveData['bunker']) && (bool)$saveData['bunker'];
        $saveData['day_price'] = isset($saveData['day_price']) && (bool)$saveData['day_price'];
        $saveData['day_product'] = isset($saveData['day_product']) && (bool)$saveData['day_product'];
        $saveData['special_price_tag'] = isset($saveData['special_price_tag']) && (bool)$saveData['special_price_tag'];

        //dd($saveData);
        $attributes = $saveData['attribute'];
        unset($saveData['attribute']);

        //dd($attributes);

        $this->productRepository->update($product->id, $saveData);

        $this->productRepository->saveFiles($product->id, $request);

        $product->categories()->sync($saveData['categories'] ?? []);


        //update product attributes
        $attr = [];
        $attr_del = [];
        foreach ($attributes as $key => $item){
            if ($item){

                $product_atribute = ProductAttributeValue::where('product_id',$product->id)
                    ->where('attribute_id',$key)->first();
                if ($product_atribute){
                    $data['integer_value'] = $item;
                    ProductAttributeValue::where('product_id',$product_atribute->product_id)
                        ->where('attribute_id',$product_atribute->attribute_id)
                        ->update($data);
                } else {
                    $attr[$key] = $item;
                }
            } else $attr_del[] = $key;
        }

        $attr_ids = array_keys($attr);

        $_attributes = Attribute::whereIn('id',$attr_ids)->get();

        $arr = [];
        foreach ($_attributes as $item){
            $arr[$item->id] = $item;
        }

        $data = [];
        foreach ($attr as $key => $item){
            $data['product_id'] = $product->id;
            $data['attribute_id'] = $arr[$key]->id;
            $data['type'] = $arr[$key]->type;

            if($data['type'] == 'boolean') $data['value'] = (bool)$item;
            else $data['value'] = $item;

            //dd($data);
            $this->productAttributeValueRepository->create($data);
        }


        ProductAttributeValue::where('product_id',$product->id)
            ->whereIn('attribute_id',$attr_del)->delete();




        return redirect(locale_route('product.index', $product->id))->with('success', __('admin.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(string $locale, Product $product)
    {
        if (!$this->productRepository->delete($product->id)) {
            return redirect(locale_route('product.show', $product->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('product.index'))->with('success', __('admin.delete_message'));
    }
}
